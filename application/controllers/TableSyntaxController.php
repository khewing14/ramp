<?php

/**
 * RAMP: Records and Activity Management Program
 *
 * LICENSE
 *
 * This source file is subject to the BSD-2-Clause license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.cs.kzoo.edu/ramp/LICENSE.txt
 *
 * @category   Ramp
 * @package    Ramp_Controller
 * @copyright  Copyright (c) 2012 Alyce Brady (http://www.cs.kzoo.edu/~abrady)
 * @license    http://www.cs.kzoo.edu/ramp/LICENSE.txt   Simplified BSD License
 *
 */

class TableSyntaxController extends Zend_Controller_Action
{

    const SUBMIT_BUTTON = 'submit';
    /* Button labels */
    const DO_IT         = 'Check Syntax';
    const CHECK_ANOTHER = 'Check Another Setting';
    const CANCEL        = 'Cancel';
    const DONE          = 'Done';

    const FILENAME = Ramp_Form_Table_GetSettingName::SETTING_NAME;

    protected $_submittedButton;
    public $adapter;

    /**
     * Initializes the attributes for this object as well as some
     * values commonly used by the associated view scripts.
     */
    public function init()
    {
        // Initialize action controller here
        $this->_submittedButton = $this->_getParam(self::SUBMIT_BUTTON);

        // Load the shared translation adapter from the zend registry
        $this->adapter = Zend_Registry::get('Zend_Translate');
    }

    /**
     * Checks the syntax of a table setting/sequence file chosen by the
     * user.
     */
    public function indexAction()
    {
        // Instantiate the form that asks for a sequence setting file.
        $form = new Ramp_Form_Table_GetSettingName();
        $this->view->form = $form;

        // Initialize the error message to be empty.
        $this->view->messages = array();
        $this->view->buttonList = array(
            $this->adapter->translate(self::DO_IT),
            $this->adapter->translate(self::CANCEL)
        );

        // For initial display, just render the form.  If this is the
        // callback after the form has been filled out, process the form.
        if ( ! $this->getRequest()->isPost() ||
             $this->_submittedButton == $this->adapter->translate(self::CHECK_ANOTHER) )
        {
            // Form will be rendered when function returns
        }
        elseif ( $this->_submittedButton == $this->adapter->translate(self::DO_IT) )
        {
            // Get the filename from the filled-out form.
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData))
            {
                $file = $formData[self::FILENAME];

                $this->view->form = null;
                $this->view->messages =
                    Ramp_Table_TableViewSequence::checkSyntax($file);
                $this->view->messages[] = "";

                $this->view->buttonList = array(
                    $this->adapter->translate(self::CHECK_ANOTHER),
                    $this->adapter->translate(self::DONE)
                );
            }
            else
            {
                $this->view->errorMsg = "Invalid input";
            }
        }
        else  // Cancel
        {
            $this->_helper->redirector('index', 'index'); // Still logged in
        }

    }

}

