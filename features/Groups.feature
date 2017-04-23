Feature: Group API

  Background:
    Given the eplite instance at "http://localhost:9001" and api key "a4690b6696e707aa016f568e04e1cdc525a5d92f7286bf62e3280a17836803b4"

  Scenario: Create a group
    When I call "createGroup"
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "groupID"
    And set placeholder "groupID" from response

  Scenario: Create a group with groupmapper
    When I call "createGroupIfNotExistsFor" with params:
      | groupMapper | 1000 |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "groupID"

  Scenario: Delete a non existing group
    When I call "deleteGroup" with params:
      | groupID | "g.0000000000000000" |
    Then the code should be "1"
    And the message should be "groupID does not exist"

  Scenario: Delete a existing group
    Given a group exists

    When I call "deleteGroup" with params:
      | groupID | {{ groupID }} |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: List pads for nonexisting group
    When I call "listPads" with params:
      | groupID | "g.0000000000000000" |
    Then the code should be "1"
    And the message should be "groupID does not exist"

  Scenario: List pads for a group
    Given a group exists

    When I call "listPads" with params:
      | groupID | {{ groupID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "padIDs"

  Scenario: Create a group pad for non existing group
    When I call "createGroupPad" with params:
      | groupID | g.0000000000000000 |
      | padName | first_pad          |
      | text    | Hello, World!      |
    And the code should be "1"
    And the message should be "groupID does not exist"

  Scenario: Create a group pad for a existing group
    Given a group exists

    When I call "createGroupPad" with params:
      | groupID | {{ groupID }} |
      | padName | first_pad     |
      | text    | Hello, World! |
    And the code should be "0"
    And the message should be "ok"
    And the data should contain "padID"

  Scenario: Create a group pad for a existing pad
    Given a group exists

    When I call "createGroupPad" with params:
      | groupID | {{ groupID }} |
      | padName | first_pad     |
      | text    | Hello, World! |
    And the code should be "0"
    And the message should be "ok"
    And the data should contain "padID"

    When I call "createGroupPad" with params:
      | groupID | {{ groupID }} |
      | padName | first_pad     |
    And the code should be "1"
    And the message should be "padName does already exist"

  Scenario: List all groups
    When I call "listAllGroups"
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "groupIDs"
