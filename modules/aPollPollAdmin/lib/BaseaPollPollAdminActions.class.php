<?php

require_once dirname(__FILE__) . '/../lib/aPollPollAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/aPollPollAdminGeneratorHelper.class.php';

/**
 * Base actions for the aPollPlugin aPollPollAdmin module.
 * 
 * @package     aPollPlugin
 * @subpackage  aPollPollAdmin
 * @author      Raffaele Bolliger <raffaele.bolliger at gmail.com>
 */
abstract class BaseaPollPollAdminActions extends autoaPollPollAdminActions {

    // You must create with at least a title
//    public function executeNew(sfWebRequest $request) {
//        $this->forward404();
//    }

    
    public function executePreviewPoll(sfWebRequest $request) {


        $this->poll_values = $request->getParameter('a_poll_poll');

        $name = $this->poll_values['type'];

        $this->poll_validation = aPollToolkit::checkPollConfiguration($name);

        $culture = $this->getUser()->getCulture();

        // filling data required to preview the poll
        $this->poll = new aPollPoll();
        $this->poll->setTitle($this->poll_values[$culture]['title']);
        $this->poll->setDescription($this->poll_values[$culture]['description']);

        $form = aPollToolkit::getPollFormName($name);
        $this->form = new $form();

        $this->form_view_template = aPollToolkit::getPollViewTemplate($name);
        $this->submit_action = aPollToolkit::getPollSubmitAction($name);

        // some fake values, just to call the form partial
        $this->pageid = 1;
        $this->name = 'dfsd';
        $this->permid = 1;
    }

    public function executeListAnswers(sfWebRequest $request) {

        $this->redirect('@a_poll_answer_admin_list_by_poll?id=' . $request->getParameter('id'));
    }

    public function executeUpdate(sfWebRequest $request) {

        $this->a_poll_poll = $this->getRoute()->getObject();
        $this->form = $this->configuration->getForm($this->a_poll_poll);

        $params = $request->getParameter($this->form->getName());

        // updating cookie to ensure thath changes done in multiple submissions choice are applied
        aPollToolkit::setShowPollToCookie($request, $this->getResponse(), $this->a_poll_poll, (bool) $params['submissions_allow_multiple']);

        parent::executeUpdate($request);
    }

    public function executeExportToExcel(sfWebRequest $request) {

        $response = $this->prepareExport();


        // generating file
        $filename = $this->poll->getSlug() . '_answers_' . date('Y-m-d-H-i-s') . '.xls';
        $response->setHttpHeader('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->addCacheControlHttpHeader('max-age=0');
        $response->setContentType('application/vnd.ms-excel');

        $this->writerFormat = 'Excel5';

        $this->setTemplate('exportToExcel');
    }

    public function executeExportToCSV(sfWebRequest $request) {

        $response = $this->prepareExport();

        // generating file
        $filename = $this->poll->getSlug() . '_answers_' . date('Y-m-d-H-i-s') . '.csv';
        $response->setHttpHeader('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->addCacheControlHttpHeader('max-age=0');
        $response->setContentType('text/csv');

    }

    protected function prepareExport() {

        if (!class_exists('PHPExcel')) {
            throw new sfException('Cannot find PHPExcel. Did you install it? PHP excel is required to export poll answers to excel.');
        }

        // Poll's form
        $this->poll = $this->getRoute()->getObject();
        $form_name = aPollToolkit::getPollFormName($this->poll->getType());

        // Answer form
        $answer_form = new aPollAnswerForm();

        // generating report content
        $this->report = $this->fillExcel(new PHPExcel(), $this->poll, new $form_name(), $answer_form);


        // setting decoration and headers
        $this->setLayout(false);
        $response = $this->getResponse();
        $response->clearHttpHeaders();

        return $response;
    }

    protected function fillExcel(PHPExcel $excel, aPollPoll $poll, aPollBaseForm $fields_form, aPollAnswerForm $answer_form) {

        // loading helpers
        sfContext::getInstance()->getConfiguration()->loadHelpers('a');

        // file properties
        $excel->getProperties()->setCreator("Buddies Sàrl")
                ->setLastModifiedBy($this->getUser()->getGuardUser()->getName())
                ->setTitle(sprintf('Poll %s answers export', $this->poll->getTitle()))
                ->setSubject(sprintf('Poll %s answers export', $this->poll->getTitle()))
                ->setDescription('Export generated at ' . date('l d F Y H:i:s'));


        // Header
        $names = array(
            a_('Id'),
            a_('Posted from'),
            a_('Submission language'),
            a_('Submission date'),
        );


        $excel->setActiveSheetIndex(0);
        $column = 'A';
        $row = 1;
        $font = 'Arial';
        $font_size = 10;

        // aPollAnswer fields
        foreach ($names as $name) {

            $cell = $column . $row;

            $excel->getActiveSheet()->setCellValue($cell, $name);
            $excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);

            $excel->getActiveSheet()->getStyle($cell)->getFont()->setName($font);
            $excel->getActiveSheet()->getStyle($cell)->getFont()->setSize($font_size);
            $excel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);

            $column++;
        }

        // aPollAnswerField fields
        foreach ($fields_form->getFieldsToSave() as $field) {

            $cell = $column . $row;

            $excel->getActiveSheet()->setCellValue($cell, $fields_form->getWidget($field)->getLabel());
            $excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);

            $excel->getActiveSheet()->getStyle($cell)->getFont()->setName($font);
            $excel->getActiveSheet()->getStyle($cell)->getFont()->setSize($font_size);
            $excel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);

            $column++;
        }

        // answers
        $answer_fields_to_report = array(
            'id',
            'remote_address',
            'culture',
            'created_at',
        );


        $row = 1;
        foreach ($poll->getAnswers() as $answer) {


            $column = 'A';
            $row++;



            foreach ($answer_fields_to_report as $field) {

                $cell = $column . $row;

                $excel->getActiveSheet()->setCellValue($cell, aPollToolkit::renderFormFieldValue($answer_form, $answer_form[$field], $answer->get($field)));

                $excel->getActiveSheet()->getStyle($cell)->getFont()->setName($font);
                $excel->getActiveSheet()->getStyle($cell)->getFont()->setSize($font_size);

                $column++;
            }

            // building array of answer fields
            $answer_fields = $answer->getFields();
            $fields = array();
            foreach ($answer_fields as $field) {

                $fields[$field->getName()] = $field->getValue();
            }

            // writing values to excel
            foreach ($fields_form->getFieldsToSave() as $name) {

                $cell = $column . $row;

                if (isset($fields[$name])) {

                    $fields_form_field = $fields_form[$name];

                    $excel->getActiveSheet()->setCellValue(
                            $cell, aPollToolkit::renderFormFieldValue($fields_form, $fields_form_field, $fields[$name])
                    );

                    $excel->getActiveSheet()->getStyle($cell)->getFont()->setName($font);
                    $excel->getActiveSheet()->getStyle($cell)->getFont()->setSize($font_size);
                }

                $column++;
            }
        }

        $excel->setActiveSheetIndex(0);


        return $excel;
    }

}
