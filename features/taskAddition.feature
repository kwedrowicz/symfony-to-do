Feature: Task addition

  Scenario: Successfully adding task
    Given I am logged in as a user
    And I follow "Create a new task"
    When I fill in "Subject" with "task subject"
    And I press "Create"
    And I should see "Task created!"

  Scenario: Adding task with too short name
    Given I am logged in as a user
    And I follow "Create a new task"
    When I fill in "Subject" with "aa"
    And I press "Create"
    And I should see "Subject must be at least 3 characters long"