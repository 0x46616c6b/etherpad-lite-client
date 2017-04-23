Feature: Author API

  Scenario: Create author
    When I call "createAuthor" with params:
      | name | author |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "authorID"

  Scenario: Create author with authorMapper
    When I call "createAuthor" with params:
      | authorMapper | 1000   |
      | name         | author |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "authorID"

  Scenario: List pads from author which not exists
    When I call "listPadsOfAuthor" with params:
      | authorID | a.0000000000000000 |
    Then the code should be "1"
    And the message should be "authorID does not exist"

  Scenario: List pads from author
    Given an author "author" exists

    When I call "listPadsOfAuthor" with params:
      | authorID | {{ authorID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should contain "padIDs"

  Scenario: Get author name
    Given an author "author" exists

    When I call "getAuthorName" with params:
      | authorID | {{ authorID }} |
    Then the code should be "0"
    And the message should be "ok"
    And the data should be "author"
