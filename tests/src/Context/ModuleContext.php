<?php
/**
 * @file
 * Contains \Drupal\nexteuropa\Context\ModuleContext.
 */

namespace Drupal\nexteuropa\Context;

use Behat\Behat\Context\Context;

/**
 * Context for disabling modules after given scenarios.
 *
 * This context can be used by other contexts. It ensures that the initial
 * module list will be restored after each scenario.
 */
class ModuleContext implements Context {

  /**
   * Initial module list to restore at the end of the test.
   *
   * @var array
   */
  protected $initialModuleList = array();

  /**
   * Stores the initial module list.
   *
   * @BeforeScenario
   */
  public function storeModules() {
    $this->initialModuleList = module_list();
  }

  /**
   * Restores the initial values of the Drupal variables.
   *
   * @AfterScenario
   */
  public function restoreInitialState() {
    $list_after = module_list();
    $lists_diff = array_values(
      array_merge(
        array_diff($this->initialModuleList, $list_after),
        array_diff($list_after, $this->initialModuleList)
      )
    );

    if (!empty($lists_diff)) {
      module_disable($lists_diff);
      drupal_uninstall_modules($lists_diff);
      drupal_flush_all_caches();

      foreach ($lists_diff as $module) {
        if (module_exists($module)) {
          $message = sprintf('Module "%s" could not be uninstalled.', $module);
          throw new \Exception($message);
        }
      }
    }
  }

}
