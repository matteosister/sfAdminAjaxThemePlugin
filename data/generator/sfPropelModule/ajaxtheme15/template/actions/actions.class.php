[?php

require_once(dirname(__FILE__).'/../lib/Base<?php echo ucfirst($this->moduleName) ?>GeneratorConfiguration.class.php');
require_once(dirname(__FILE__).'/../lib/Base<?php echo ucfirst($this->moduleName) ?>GeneratorHelper.class.php');

/**
 * <?php echo $this->getModuleName() ?> actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 */
abstract class <?php echo $this->getGeneratedModuleName() ?>Actions extends <?php echo $this->getActionsBaseClass()."\n" ?>
{
  public function preExecute()
  {
    $this->configuration = new <?php echo $this->getModuleName() ?>GeneratorConfiguration();

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($this->getActionName())))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.pre_execute', array('configuration' => $this->configuration)));

    $this->helper = new <?php echo $this->getModuleName() ?>GeneratorHelper();
  }

  public function collectFormErrors(sfFormFieldSchema $formFieldSchema, &$array)
  {
    foreach ($formFieldSchema as $key => $formField) {
      if ($formField->hasError()) {
        if ($formField instanceof sfFormFieldSchema) {
           $this->collectFormErrors($formField, $array);
        } else {
          if (null !== $error = (string)$formField->getError()) $array[$formField->renderId()] = $error;
        }
      }
    }
    return true;
  }
  
<?php include dirname(__FILE__).'/../../parts/indexAction.php' ?>

<?php if ($this->configuration->hasFilterForm()): ?>
<?php include dirname(__FILE__).'/../../parts/filterAction.php' ?>
<?php endif; ?>

<?php include dirname(__FILE__).'/../../parts/newAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/createAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/editAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/updateAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/deleteAction.php' ?>

<?php if ($this->configuration->getValue('list.batch_actions')): ?>
<?php include dirname(__FILE__).'/../../parts/batchAction.php' ?>
<?php endif; ?>

<?php include dirname(__FILE__).'/../../parts/processFormAction.php' ?>

<?php if ($this->configuration->hasFilterForm()): ?>
<?php include dirname(__FILE__).'/../../parts/filtersAction.php' ?>
<?php endif; ?>

<?php include dirname(__FILE__).'/../../parts/paginationAction.php' ?>

<?php include dirname(__FILE__).'/../../parts/sortingAction.php' ?>
}
