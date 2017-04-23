Feature: PadContent API

  Background:
    Given the eplite instance at "http://localhost:9001" and api key "a4690b6696e707aa016f568e04e1cdc525a5d92f7286bf62e3280a17836803b4"
    And all pads are deleted

  Scenario: Get text for a pad
    Given a pad "pad" exists

    When I call "getText" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "text"

  Scenario: Set text for a pad
    Given a pad "pad" exists

    When I call "setText" with params:
      | padID | {{ padID }} |
      | text  | text        |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Append text for a pad
    Given a pad "pad" exists

    When I call "appendText" with params:
      | padID | {{ padID }} |
      | text  | text        |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Get html for a pad
    Given a pad "pad" exists

    When I call "getHTML" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "html"

#  Scenario: Set html for a pad
#    Given a pad "pad" exists
#
#    When I call "setHTML" with params:
#      | padID | {{ padID }} |
#      | html  | html        |
#    Then the code should be "0"
#    And the message should be "ok"

  Scenario: Get attribute pool for a pad
    Given a pad "pad" exists

    When I call "getAttributePool" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "pool"

  Scenario: Get revision changeset for a pad
    Given a pad "pad" exists

    When I call "getRevisionChangeset" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
