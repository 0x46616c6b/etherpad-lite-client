Feature: Pad API

  Background:
    Given the eplite instance at "http://localhost:9001" and api key "a4690b6696e707aa016f568e04e1cdc525a5d92f7286bf62e3280a17836803b4"
    And all pads are deleted

  Scenario: Create a new pad
    When I call "createPad" with params:
      | padID | new_pad |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Create a new pad with prohibited characters
    When I call "createPad" with params:
      | padID | pad#name |
    Then the code should be "1"
    And the message should be "malformed padID: Remove special characters"

  Scenario: Create a new pad which already exists
    Given a pad "new_pad" exists

    When I call "createPad" with params:
      | padID | new_pad |
    Then the code should be "1"
    And the message should be "padID does already exist"

  Scenario: Get revision count from a non exisiting pad
    When I call "getRevisionsCount" with params:
      | padID | pad |
    Then the code should be "1"
    And the message should be "padID does not exist"

  Scenario: Get revision count
    Given a pad "new_pad" exists

    When I call "getRevisionsCount" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "revisions"

  Scenario: Get saved revisions from a non existing pad
    When I call "getSavedRevisionsCount" with params:
      | padID | pad |
    Then the code should be "1"
    And the message should be "padID does not exist"

  Scenario: Get saved revisions from a pad
    Given a pad "new_pad" exists

    When I call "getSavedRevisionsCount" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "savedRevisions"

  Scenario: List saved revisions from a non existing pad
    When I call "listSavedRevisions" with params:
      | padID | pad |
    Then the code should be "1"
    And the message should be "padID does not exist"

  Scenario: List saved revisions from a pad
    Given a pad "new_pad" exists
    When I call "listSavedRevisions" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "savedRevisions"

  Scenario: Save revision for a non existing pad
    When I call "saveRevision" with params:
      | padID | pad |
    Then the code should be "1"
    And the message should be "padID does not exist"

  Scenario: Save revision for a pad
    Given a pad "new_pad" exists

    When I call "saveRevision" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Get current editing user count for a non existing pad
    When I call "padUsersCount" with params:
      | padID | pad |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "padUsersCount"

  Scenario: Get current editing user count for a pad
    Given a pad "new_pad" exists

    When I call "padUsersCount" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "padUsersCount"

  Scenario: Get current editing user for a non existing pad
    When I call "padUsers" with params:
      | padID | pad |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "padUsers"

  Scenario: Get current editing user for a pad
    Given a pad "new_pad" exists

    When I call "padUsers" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "padUsers"

  Scenario: Delete a non existing pad
    When I call "deletePad" with params:
      | padID | pad |
    Then the code should be "1"
    And the message should be "padID does not exist"

  Scenario: Delete a pad
    Given a pad "new_pad" exists

    When I call "deletePad" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Move a non existing pad
    When I call "movePad" with params:
      | sourceID      | pad1 |
      | destinationID | pad2 |
    Then the code should be "1"
    And the message should be "padID does not exist"

  Scenario: Move a pad
    Given a pad "pad1" exists

    When I call "movePad" with params:
      | sourceID      | {{ padID }} |
      | destinationID | pad2        |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Get readonly id for a non existing pad
    When I call "getReadOnlyID" with params:
      | padID | pad |
    Then the code should be "1"
    And the message should be "padID does not exist"

  Scenario: Get readonly id for a pad
    Given a pad "new_pad" exists

    When I call "getReadOnlyID" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "readOnlyID"

#  Scenario: Get pad id from a readonly pad
#    Given a readonly pad
#
#    When I call "getPadID" with params:
#      | readOnlyID | {{ readOnlyID }} |
#    Then the code should be "0"
#    And the message should be "ok"
#    And the data should contain "padID"

  Scenario: Set public status for a pad
    Given a group pad exists

    When I call "setPublicStatus" with params:
      | padID        | {{ padID }} |
      | publicStatus | 1           |
    Then the code should be "0"
    And the message should be "ok"

    When I call "setPublicStatus" with params:
      | padID        | {{ padID }} |
      | publicStatus | 0           |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Get public status for a pad
    Given a group pad exists

    When I call "getPublicStatus" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "publicStatus"

  Scenario: Set a password for a pad
    Given a group pad exists

    When I call "setPassword" with params:
      | padID    | {{ padID }} |
      | password | password    |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Check if a pad is password protected
    Given a group pad exists

    When I call "isPasswordProtected" with params:
      | padID    | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "isPasswordProtected"

  Scenario: List authors of the pad
    Given a pad "pad" exists

    When I call "listAuthorsOfPad" with params:
      | padID    | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "authorIDs"

  Scenario: Get last edited time for a pad
    Given a pad "pad" exists

    When I call "getLastEdited" with params:
      | padID    | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "lastEdited"

  Scenario: Send client message for a pad
    Given a pad "pad" exists

    When I call "sendClientsMessage" with params:
      | padID    | {{ padID }} |
      | msg      | message     |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Check token
    When I call "checkToken"
    Then the code should be "0"
    And the message should be "ok"

  Scenario: List all pads
    When I call "listAllPads"
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "padIDs"
