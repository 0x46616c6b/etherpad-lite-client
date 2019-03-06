Feature: PadContent API

  Background:
    Given all pads are deleted

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

  Scenario: Get html for a pad
    Given a pad "pad" exists

    When I call "getHTML" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "html"
