@javascript
Feature: Heartbeat

  Scenario: I can filter by boolean field
    Given I am on the homepage
    And I go to "datasheet/use-cases"
    # 0 value
    When I click element with selector "[data-datasheet-filter='isLong']"
    Then I click element with selector "[id='datasheet-filter-options'] div:first-child"
    Then I click element with selector "[value='Filter']"
    Then I see "Dil Bechara"
    Then I dont see "The Shawshank Redemption" "The Godfather (Крестный отец)"
    # 1 value
    When I click element with selector "[data-datasheet-filter-clear='isLong']"
    When I click element with selector "[data-datasheet-filter='isLong']"
    Then I click element with selector "[id='datasheet-filter-options'] div:last-child"
    Then I click element with selector "[value='Filter']"
    Then I see "The Shawshank Redemption" "The Godfather (Крестный отец)"
    Then I dont see "Dil Bechara"
