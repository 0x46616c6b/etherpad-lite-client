<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use EtherpadLite\Client;
use EtherpadLite\Response;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var Client|null */
    private static $client;
    /** @var Response|null */
    private $response;
    /** @var array */
    private $placeholders = array();

    /**
     * FeatureContext constructor.
     */
    public function __construct()
    {
        $apikey = (getenv('API_KEY')) ?: 'cqOtzCYEUyzR23s8tftePVo8HHO';
        $baseUrl = (getenv('BASE_URL')) ?: 'http://localhost:9001';

        self::$client = new Client($apikey, $baseUrl);
    }

    /**
     * @When I call :method
     */
    public function iCall($method)
    {
        $this->callApi($method);
    }

    /**
     * @When I call :method with params:
     */
    public function iCallWithParams($method, TableNode $table)
    {
        $params = array();

        foreach ($table->getRowsHash() as $param) {
            $params[] = $this->transformValue($param);
        }

        $this->callApi($method, $params);
    }

    /**
     * @Then the code should be :expected
     */
    public function theCodeShouldBe($expected)
    {
        $response = $this->getResponse();
        $code = $response->getCode();

        if ((int)$expected !== $code) {
            $this->handleError();
        }
    }

    /**
     * @Then the message should be :message
     */
    public function theMessageShouldBe($message)
    {
        $response = $this->getResponse();

        if ((string)$message !== $response->getMessage()) {
            $this->handleError();
        }
    }

    /**
     * @Then the data should contain :key
     */
    public function theDataShouldContainKey($key)
    {
        $response = $this->getResponse();
        $data = $response->getData();

        $key = $this->transformValue($key);

        if (!is_array($data) || !isset($data[$key])) {
            $this->handleError();
        }
    }

    /**
     * @Then the data should be :data
     */
    public function theDataShouldBe($data)
    {
        if ($data !== $this->getResponse()->getData()) {
            $this->handleError();
        }
    }

    /**
     * @Then set placeholder :placeholder from response
     */
    public function setPlaceholderFromResponse($placeholder)
    {
        $data = $this->getResponse()->getData();

        if (isset($data[$placeholder])) {
            $this->setPlaceholder($placeholder, $data[$placeholder]);
        } else {
            $this->handleError(sprintf("The placeholder '%s' could not found in response", $placeholder));
        }
    }

    /**
     * @Then debug response
     */
    public function debugResponse()
    {
        // TODO: better variable output
        print_r($this->getResponse()->getResponse());
    }

    /**
     * @Given all pads are deleted
     */
    public function allPadsAreDeleted()
    {
        $this->callApi("listAllPads");
        $data = $this->getResponse()->getData();

        if (isset($data["padIDs"]) && is_array($data["padIDs"])) {
            foreach ($data["padIDs"] as $padID) {
                $this->callApi("deletePad", array($padID));
            }
        }

        $this->response = null;
    }

    /**
     * @Given an author :name exists
     */
    public function anAuthorExists($name)
    {
        $this->callApi("createAuthor", array($name));
        $this->setPlaceholderFromResponse("authorID");
    }

    /**
     * @Given a group exists
     */
    public function aGroupExists()
    {
        $this->callApi("createGroup");
        $this->setPlaceholderFromResponse("groupID");
    }

    /**
     * @Given a pad :padName exists
     */
    public function aPadExists($padName)
    {
        $this->callApi("createPad", array($padName));
        $this->setPlaceholder("padID", $padName);
    }

    /**
     * @Given a readonly pad
     */
    public function aReadonlyPad()
    {
        $this->aPadExists("pad");
        $this->callApi("getReadOnlyID", array("pad"));
        $this->setPlaceholderFromResponse("readOnlyID");
    }

    /**
     * @Given a group pad exists
     */
    public function aGroupPadExists()
    {
        $this->aGroupExists();
        $this->callApi("createGroupPad", array($this->getPlaceholder("groupID", "pad")));
        $this->setPlaceholderFromResponse("padID");
    }

    /**
     * @param $method
     * @param array $params
     */
    private function callApi($method, array $params = array())
    {
        $this->checkIfClientIsInitialized();
        $this->response = call_user_func_array(array(self::$client, $method), $params);
    }

    /**
     * @throws Exception
     */
    private function checkIfClientIsInitialized()
    {
        if (null === self::$client) {
            throw new Exception("The Client is not initialized");
        }
    }

    private function transformValue($value)
    {
        $matches = null;

        if (preg_match('/{{(.*)}}/', $value, $matches)) {
            if (isset($matches[1])) {
                $key = trim($matches[1]);
                $value = $this->getPlaceholder($key);
            }
        }

        return $value;
    }

    /**
     * @return Response
     * @throws Exception
     */
    private function getResponse()
    {
        if (null === $this->response) {
            throw new Exception("Response is not set");
        }

        return $this->response;
    }

    /**
     * @param string $message
     * @throws Exception
     */
    private function handleError($message = '')
    {
        $this->debugResponse();

        throw new Exception($message);
    }

    /**
     * @param $key
     * @param $data
     */
    private function setPlaceholder($key, $data)
    {
        $this->placeholders[$key] = $data;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    private function getPlaceholder($key)
    {
        return isset($this->placeholders[$key]) ? $this->placeholders[$key] : null;
    }
}
