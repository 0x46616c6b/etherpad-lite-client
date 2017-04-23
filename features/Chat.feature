Feature: Chat API

  Background:
    Given the eplite instance at "http://localhost:9001" and api key "a4690b6696e707aa016f568e04e1cdc525a5d92f7286bf62e3280a17836803b4"
    And all pads are deleted

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

  Scenario: Get the chat head for a pad
    Given a pad "pad" exists
    And an author "author" exists

    When I call "appendChatMessage" with params:
      | padID    | {{ padID }}    |
      | text     | text           |
      | authorID | {{ authorID }} |
    Then the code should be "0"
    And the message should be "ok"
