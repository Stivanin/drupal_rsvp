<?php

namespace Drupal\rsvplist;

/**
 * Implements the functions setEnabled, isEnabled and delEnabled.
 */

use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;

/**
 * Defines a service for managing RSVP list enabled for nodes.
 */
class EnablerService {

  /**
   * Constructor.
   */
  public function __construct() {
  }

  /**
   * Functions add the specified data in table rsvplist_enabled.
   */
  public function setEnabled(Node $node) {
    if (!$this->isEnabled($node)) {
      $insert = Database::getConnection()->insert('rsvplist_enabled');
      $insert->fields(['nid'], [$node->id()]);
      $insert->execute();
    }
  }

  /**
   * Function search for the specified data in table rsvplist_enabled.
   */
  public function isEnabled(Node $node) {
    if ($node->isNew()) {
      return FALSE;
    }

    $select = Database::getConnection()->select('rsvplist_enabled', 're');
    $select->fields('re', ['nid']);
    $select->condition('nid', $node->id());
    $results = $select->execute();

    return !empty($results->fetchCol());
  }

  /**
   * Fucntion deletes the specified data from the table rsvplist_enabled.
   */
  public function delEnabled(Node $node) {
    $delete = Database::getConnection()->delete('rsvplist_enabled');
    $delete->condition('nid', $node->id());
    $delete->execute();
  }

}
