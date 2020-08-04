<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

class FeatureContext extends DrupalContext implements Context, SnippetAcceptingContext
{
    const PAGE_LOAD_TIME_SECONDS = 1;
    const slow = true;
    public $screenshot_dir = './features/screenshots';

    protected function iAmOnThe($page = '/', $width = 1600, $height = 1200)
    {
        $this->visitPath('/testing/reset');
        $this->getSession()->resizeWindow($width, $height, 'current');
        $this->visitPath($page);
        $this->iWaitForPageLoad();
    }

    /**
     * Checks, that page does not contain specified texts
     *
     * @Then /^I dont see "([^"]*)"(?: "([^"]*)")?(?: "([^"]*)")?(?: "([^"]*)")?(?: "([^"]*)")?$/
     */
    public function assertPageDoesntContainsTexts($text1, $text2 = null, $text3 = null, $text4 = null, $text5 = null)
    {
        $texts = [$text1, $text2, $text3, $text4, $text5];

        foreach ($texts as $text) {
            if (is_null($text)) {
                continue;
            }
            $this->assertSession()->pageTextNotContains($this->fixStepArgument($text));
        }
    }

    /**
     * Checks, that page contains specified texts
     *
     * @Then /^I see "([^"]*)"(?: "([^"]*)")?(?: "([^"]*)")?(?: "([^"]*)")?(?: "([^"]*)")?$/
     */
    public function assertPageContainsTexts($text1, $text2 = null, $text3 = null, $text4 = null, $text5 = null)
    {
        $texts = [$text1, $text2, $text3, $text4, $text5];

        foreach ($texts as $text) {
            if (is_null($text)) {
                continue;
            }
            $this->assertSession()->pageTextContains($this->fixStepArgument($text));
        }
    }

    /**
     * @Given /^I am on the website page$/
     */
    public function iAmOnTheWebsitePage()
    {
        $this->iAmOnThe();
    }

    /**
     * @Given /^I am on the website mobile page$/
     */
    public function iAmOnTheWebsiteMobilePage()
    {
        $this->iAmOnThe('/', 375, 667);
    }

    /**
     * @Given /^I wait a lot$/
     */
    public function iWaitALot()
    {
        sleep(60);
    }

    /**
     * @Given /^I wait for page load$/
     */
    public function iWaitForPageLoad()
    {
        sleep(self::PAGE_LOAD_TIME_SECONDS);
    }

    /**
     * Setting screen size to 320x480 (mobile portrait)
     * iPhone 4.7-inch
     * iPhone 6, iPhone 6S, iPhone 7, iPhone 8
     * @Given /^The size is mobile$/
     */
    public function theSizeIsMobile()
    {
        $this->getSession()->resizeWindow(375, 667, 'current');
    }

    /**
     * @When /^I checking checkbox with name "([^"]*)"$/
     * Param = NAME ONLY
     */
    public function iCheckingCheckboxByName($name)
    {
        $this->iWaitForSeconds(1);
        $selector = sprintf("[name='%s']", $name);
        $element = $this->getSession()->getPage()->find('css', $selector);

        if (!$element) {
            throw new Exception('Checkbox not found by name: ' . $name);
        }
        $element->check();
    }

    /**
     * @When /^I unchecking checkbox with name "([^"]*)"$/
     * Param = NAME ONLY
     */
    public function iUncheckingCheckboxByName($name)
    {
        $this->iWaitForSeconds(1);
        $selector = sprintf("[name='%s']", $name);
        $element = $this->getSession()->getPage()->find('css', $selector);

        if (!$element) {
            throw new Exception('Checkbox not found by name: ' . $name);
        }
        $element->uncheck();
    }

    /**
     * @When /^I click element with selector "([^"]*)"$/
     */
    public function iClickElementWithSelector($selector)
    {
        $this->getSession()->getPage()->find('css', $selector)->click();
    }

    /**
     * @When /^I click "([^"]*)"( "([^"]*)")?$/
     */
    public function iClick($text, $null = null, $additional = null)
    {
        $session = $this->getSession();
        $xpath = sprintf('//div[text()="%s" and contains(@class, \'tap\')%s]', $text, ($additional ? ' and @' . trim($additional) : ''));
        $selector = $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath);
        $element = $session->getPage()->find('xpath', $selector);

        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Cannot find text: "%s"', $text));
        }
//        var_dump($element->getXpath());
//        var_dump($element->getOuterHtml());
        $element->click();

        if (static::slow) {
            $this->iWaitForSeconds(2);
        }
    }

    /**
     * Fills in specified field with date
     * Example: When I fill in "field_ID" with date "now"
     * Example: When I fill in "field_ID" with date "-7 days"
     * Example: When I fill in "field_ID" with date "+7 days"
     * Example: When I fill in "field_ID" with date "-/+0 weeks"
     * Example: When I fill in "field_ID" with date "-/+0 years"
     *
     * @When /^(?:|I )fill in "(?P<field>(?:[^"]|\\")*)" with date "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function fillDateField($field, $value)
    {
        $newDate = strtotime("$value");

        $dateToSet = date("d/m/Y", $newDate);
        $this->getSession()->getPage()->fillField($field, $dateToSet);
    }

    /**
     * @Given /^I am in the office$/
     */
    public function iAmInTheOffice()
    {
        $this->iAmOnHomepage();
        $this->clickLink('Sign in');
        $this->fillField('phoneNumber', 1);
        $this->fillField('password', 1);
        $this->pressButton('Log in');
        $this->clickLink('Office');
        $this->assertPageContainsText('Staging');

        if (static::slow) {
            $this->iWaitForSeconds(2);
        }
    }

    /**
     * @Then /^I should see time "([^"]*)"$/
     */
    public function iShouldSeeTime($format)
    {
        $date = new \DateTime("now", new \DateTimeZone("Europe/Kiev"));
        $this->assertSession()->pageTextContains($this->fixStepArgument($date->format($format)));
    }

    /**
     * @Then /^I should see rounded time "([^"]*)" with format "([^"]*)"$/
     */
    public function iShouldSeeRoundedTimeWithFormat($time, $format)
    {
        $date = new \DateTime($time, new \DateTimeZone("Europe/Kiev"));
        $left = $date->format('i') % 5;
        $minutesShift = $left === 4 ? 6 : 5 - $left;
        $date->modify(sprintf('+%s minutes', $minutesShift));
        echo 'Asserting page has next time text: `' . $date->format($format) . '`';
        $this->assertSession()->pageTextContains($this->fixStepArgument($date->format($format)));
    }

    /**
     * @When /^I click on element contains "([^"]*)"$/
     */
    public function iClickOnElementContains($text)
    {
        $page = $this->getSession()->getPage();
        $tags = ['div', 'span', 'a', 'button'];

        foreach ($tags as $tag) {
            $element = $page->find("css", sprintf('%s.tap:contains(%s)', $tag, $text));

            if ($element) {
//                var_dump($element->getXpath());
//                var_dump($element->getOuterHtml());
                $element->click();

                if (static::slow) {
                    $this->iWaitForSeconds(2);
                }

                return;
            }
        }

        throw new Exception(sprintf('Element %s containing text `%s` couldn`t be found', implode(', ', $tags), $text));
    }

    /**
     * @When /^Element exists "([^"]*)"$/
     */
    public function elementExists($selector)
    {
        $element = $this->getSession()->getPage()->find('css', $selector);

        if (is_null($element)) {
            throw new Exception('Element doesnt exists: ' . $selector);
        }
    }

    /**
     * @When /^Element not exists "([^"]*)"$/
     */
    public function elementNotExists($selector)
    {
        $element = $this->getSession()->getPage()->find('css', $selector);

        if (!is_null($element)) {
            throw new Exception('Element doesnt exists: ' . $selector);
        }
    }

    /**
     * @When /^I send a "([^"]*)" request to "([^"]*)"$/
     *
     * @param $method
     * @param $uri
     */
    public function iSendARequestTo($method, $uri)
    {
        $client = $this->getSession()->getDriver()->getClient();
        $this->response = $client->request($method, $this->baseUrl . $uri);
    }

    /**
     * @Then /^the response type should be "([^"]*)"$/
     *
     * @param $type
     * @throws Exception
     */
    public function theResponseTypeShouldBeJson($type)
    {
        $headers = $this->getSession()->getResponseHeaders();

        if ($headers['Content-Type'][0] != $type) {
            throw new Exception('Invalid response type');
        }
    }

    /**
     * @When /^I click the radio button with "([^"]*)" label name$/
     */
    public function iSelectTheRadioButton($labelText)
    {
        // Find the label by its text, then use that to get the radio item's ID
        $radioId = null;
        /** #var $label NodeElement */
        foreach ($this->getSession()->getPage()->findAll('css', 'label') as $label) {
            if ($labelText === $label->getText()) {
                $label->click();
            }
        }
    }
}