Feature: Session API

  Background:
    Given the eplite instance at "http://localhost:9001" and api key "a4690b6696e707aa016f568e04e1cdc525a5d92f7286bf62e3280a17836803b4"

  Scenario: Create session for non existing group
    When I call "createSession" with params:
      | groupID    | g.0000000000000000 |
      | authorID   | a.0000000000000000 |
      | validUntil | 1492903595         |
    Then the code should be "1"
    And the message should be "groupID does not exist"

  Scenario: Create session for non existing author
    Given a group exists

    When I call "createSession" with params:
      | groupID    | {{ groupID }}      |
      | authorID   | a.0000000000000000 |
      | validUntil | 1492903595         |
    Then the code should be "1"
    And the message should be "authorID does not exist"

  Scenario: Create session
    Given a group exists
    And an author "author" exists

    When I call "createSession" with params:
      | groupID    | {{ groupID }}  |
      | authorID   | {{ authorID }} |
      | validUntil | 4102444800     |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Delete a session which not exists
    When I call "deleteSession" with params:
      | sessionID | s.0000000000000000 |
    Then the code should be "1"
    And the message should be "sessionID does not exist"

  Scenario: Delete a session
    Given a group exists
    And an author "author" exists

    When I call "createSession" with params:
      | groupID    | {{ groupID }}  |
      | authorID   | {{ authorID }} |
      | validUntil | 4102444800     |
    Then the code should be "0"
    And the message should be "ok"
    And set placeholder "sessionID" from response

    When I call "deleteSession" with params:
      | sessionID | {{ sessionID }} |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: Get session info of a non existing session
    When I call "getSessionInfo" with params:
      | sessionID | s.0000000000000000 |
    Then the code should be "1"
    And the message should be "sessionID does not exist"

  Scenario: Get session info
    Given a group exists
    And an author "author" exists

    When I call "createSession" with params:
      | groupID    | {{ groupID }}  |
      | authorID   | {{ authorID }} |
      | validUntil | 4102444800     |
    Then the code should be "0"
    And the message should be "ok"
    And set placeholder "sessionID" from response

    When I call "getSessionInfo" with params:
      | sessionID | {{ sessionID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "authorID"
    And the data should contain "groupID"
    And the data should contain "validUntil"

  Scenario: List Session of non existing group
    When I call "listSessionsOfGroup" with params:
      | groupID | g.0000000000000000 |
    Then the code should be "1"
    And the message should be "groupID does not exist"

  Scenario: List Session of a group
    Given a group exists

    When I call "listSessionsOfGroup" with params:
      | groupID | {{ groupID }} |
    Then the code should be "0"
    And the message should be "ok"

  Scenario: List Session of non existing author
    When I call "listSessionsOfAuthor" with params:
      | authorID | a.0000000000000000 |
    Then the code should be "1"
    And the message should be "authorID does not exist"

  Scenario: List Session of a author
    Given an author "author" exists

    When I call "listSessionsOfAuthor" with params:
      | authorID | {{ authorID }} |
    Then the code should be "0"
    And the message should be "ok"
