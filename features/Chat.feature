Feature: Chat API

  Background:
    Given all pads are deleted

  Scenario: Get the chat history for a pad
    Given a pad "pad" exists

    When I call "getChatHistory" with params:
      | padID | {{ padID }} |
    Then the code should be "1"
    And the message should be "start is higher than the current chatHead"

  Scenario: Get the chat head for a pad
    Given a pad "pad" exists

    When I call "getChatHead" with params:
      | padID | {{ padID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "chatHead"
