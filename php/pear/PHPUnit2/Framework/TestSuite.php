<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * PHP Version 5
 *
 * Copyright (c) 2002-2006, Sebastian Bergmann <sb@sebastian-bergmann.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 * 
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRIC
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   Testing
 * @package    PHPUnit2
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2002-2006 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    CVS: $Id: TestSuite.php,v 1.26.2.11 2005/12/17 16:04:56 sebastian Exp $
 * @link       http://pear.php.net/package/PHPUnit2
 * @since      File available since Release 2.0.0
 */

require_once 'PHPUnit2/Framework/Test.php';
require_once 'PHPUnit2/Framework/TestCase.php';
require_once 'PHPUnit2/Framework/TestResult.php';
require_once 'PHPUnit2/Runner/BaseTestRunner.php';
require_once 'PHPUnit2/Util/Fileloader.php';

/**
 * A TestSuite is a composite of Tests. It runs a collection of test cases.
 *
 * Here is an example using the dynamic test definition.
 *
 * <code>
 * <?php
 * $suite = new PHPUnit2_Framework_TestSuite;
 * $suite->addTest(new MathTest('testPass'));
 * ?>
 * </code>
 *
 * Alternatively, a TestSuite can extract the tests to be run automatically.
 * To do so you pass a ReflectionClass instance for your
 * PHPUnit2_Framework_TestCase class to the PHPUnit2_Framework_TestSuite
 * constructor.
 *
 * <code>
 * <?php
 * $suite = new PHPUnit2_Framework_TestSuite(
 *   new ReflectionClass('MathTest')
 * );
 * ?>
 * </code>
 *
 * This constructor creates a suite with all the methods starting with
 * "test" that take no arguments.
 *
 * @category   Testing
 * @package    PHPUnit2
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2002-2006 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 2.3.6
 * @link       http://pear.php.net/package/PHPUnit2
 * @since      Class available since Release 2.0.0
 */
class PHPUnit2_Framework_TestSuite implements PHPUnit2_Framework_Test {
    /**
     * The name of the test suite.
     *
     * @var    string
     * @access private
     */
    private $name = '';

    /**
     * The tests in the test suite.
     *
     * @var    array
     * @access private
     */
    private $tests = array();

    /**
     * Constructs a new TestSuite:
     *
     *   - PHPUnit2_Framework_TestSuite() constructs an empty TestSuite.
     *
     *   - PHPUnit2_Framework_TestSuite(ReflectionClass) constructs a
     *     TestSuite from the given class.
     *
     *   - PHPUnit2_Framework_TestSuite(ReflectionClass, String)
     *     constructs a TestSuite from the given class with the given
     *     name.
     *
     *   - PHPUnit2_Framework_TestSuite(String) either constructs a
     *     TestSuite from the given class (if the passed string is the
     *     name of an existing class) or constructs an empty TestSuite
     *     with the given name.
     *
     * @param  mixed  $theClass
     * @param  string $name
     * @throws Exception
     * @access public
     */
    public function __construct($theClass = '', $name = '') {
        $argumentsValid = FALSE;

        if (is_object($theClass) &&
            $theClass instanceof ReflectionClass) {
            $argumentsValid = TRUE;
        }

        else if (is_string($theClass) && $theClass !== '' && class_exists($theClass)) {
            $argumentsValid = TRUE;

            if ($name == '') {
                $name = $theClass;
            }

            $theClass = new ReflectionClass($theClass);
        }

        else if (is_string($theClass)) {
            $this->setName($theClass);
            return;
        }

        if (!$argumentsValid) {
            throw new Exception;
        }

        if ($name != '') {
            $this->setName($name);
        } else {
            $this->setName($theClass->getName());
        }

        $constructor = $theClass->getConstructor();

        if ($constructor === NULL ||
            !$constructor->isPublic()) {
            $this->addTest(
              self::warning(
                sprintf(
                  'Class %s has no public constructor',

                  $theClass->getName()
                )
              )
            );

            return;
        }

        $methods = $theClass->getMethods();
        $names   = array();

        foreach ($methods as $method) {
            $this->addTestMethod($method, $names, $theClass);
        }

        if (empty($this->tests)) {
            $this->addTest(
              self::warning(
                sprintf(
                  'No tests found in %s',

                  $theClass->getName()
                )
              )
            );
        }
    }

    /**
     * Returns a string representation of the test suite.
     *
     * @return string
     * @access public
     */
    public function toString() {
        return $this->getName();
    }

    /**
     * Adds a test to the suite.
     *
     * @param  PHPUnit2_Framework_Test $test
     * @access public
     */
    public function addTest(PHPUnit2_Framework_Test $test) {
        $this->tests[] = $test;
    }

    /**
     * Adds the tests from the given class to the suite.
     *
     * @param  mixed $testClass
     * @access public
     */
    public function addTestSuite($testClass) {
        if (is_string($testClass) &&
            class_exists($testClass)) {
            $testClass = new ReflectionClass($testClass);
        }

        if (is_object($testClass) &&
            $testClass instanceof ReflectionClass) {
            $this->addTest(new PHPUnit2_Framework_TestSuite($testClass));
        }
    }

    /**
     * Wraps both <code>addTest()</code> and <code>addTestSuite</code>
     * as well as the separate import statements for the user's convenience.
     *
     * If the named file cannot be read or there are no new tests that can be
     * added, a <code>PHPUnit2_Framework_Warning</code> will be created instead,
     * leaving the current test run untouched.
     *
     * @param  string $filename
     * @throws Exception
     * @access public
     * @since  Method available since Release 2.3.0
     * @author Stefano F. Rausch <stefano@rausch-e.net>
     */
    public function addTestFile($filename) {
        if (!is_string($filename) || !file_exists($filename)) {
            throw new Exception;
        }

        $declaredClasses = get_declared_classes();

        PHPUnit2_Util_Fileloader::checkAndLoad($filename);

        $newClasses = array_values(
          array_diff(get_declared_classes(), $declaredClasses)
        );

        $testsFound = 0;

        foreach ($newClasses as $class) {
            if (preg_match('"Tests?$"', $class)) {
                try {
                    $suiteMethod = new ReflectionMethod(
                      $class, PHPUnit2_Runner_BaseTestRunner::SUITE_METHODNAME
                    );

                    $this->addTest($suiteMethod->invoke(NULL));
                } catch (ReflectionException $e) {
                    $this->addTestSuite(new ReflectionClass($class));
                }

                $testsFound++;
            }
        }

        if ($testsFound == 0) {
            $this->addTest(
              new PHPUnit2_Framework_Warning('No tests found in file ' . $filename)
            );
        }
    }

    /**
     * Wrapper for addTestFile() that adds multiple test files.
     *
     * @param  Array $filenames
     * @throws Exception
     * @access public
     * @since  Method available since Release 2.3.0
     */
    public function addTestFiles($filenames) {
        foreach ($filenames as $filename) {
            $this->addTestFile($filename);
        }
    }

    /**
     * Counts the number of test cases that will be run by this test.
     *
     * @return integer
     * @access public
     */
    public function countTestCases() {
        $count = 0;

        foreach ($this->tests as $test) {
            $count += $test->countTestCases();
        }

        return $count;
    }

    /**
     * @param  ReflectionClass $theClass
     * @param  string          $name
     * @return PHPUnit2_Framework_Test
     * @access public
     * @static
     */
    public static function createTest(ReflectionClass $theClass, $name) {
        if (!$theClass->isInstantiable()) {
            return self::warning(
              sprintf(
                'Cannot instantiate test case %s.',
                $theClass->getName()
              )
            );
        }

        $constructor = $theClass->getConstructor();

        if ($constructor !== NULL) {
            $parameters = $constructor->getParameters();

            if (sizeof($parameters) == 0) {
                $test = $theClass->newInstance();

                if ($test instanceof PHPUnit2_Framework_TestCase) {
                    $test->setName($name);
                }
            }

            else if (sizeof($parameters) == 1 &&
                     $parameters[0]->getClass() === NULL) {
                $test = $theClass->newInstance($name);
            }

            else {
                return self::warning(
                  sprintf(
                    'Constructor of class %s is not TestCase($name) or TestCase().',
                    $theClass->getName()
                  )
                );
            }
        }

        return $test;
    }

    /**
     * Creates a default TestResult object.
     *
     * @return PHPUnit2_Framework_TestResult
     * @access protected
     */
    protected function createResult() {
        return new PHPUnit2_Framework_TestResult;
    }

    /**
     * Returns the name of the suite.
     *
     * @return string
     * @access public
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Runs the tests and collects their result in a TestResult.
     *
     * @param  PHPUnit2_Framework_TestResult $result
     * @return PHPUnit2_Framework_TestResult
     * @throws Exception
     * @access public
     */
    public function run($result = NULL) {
        if ($result === NULL) {
            $result = $this->createResult();
        }

        // XXX: Workaround for missing ability to declare type-hinted parameters as optional.
        else if (!($result instanceof PHPUnit2_Framework_TestResult)) {
            throw new Exception(
              'Argument 1 must be an instance of PHPUnit2_Framework_TestResult.'
            );
        }

        $result->startTestSuite($this);

        foreach ($this->tests as $test) {
            if ($result->shouldStop()) {
                break;
            }

            $this->runTest($test, $result);
        }

        $result->endTestSuite($this);

        return $result;
    }

    /**
     * Runs a test.
     *
     * @param  PHPUnit2_Framework_Test        $test
     * @param  PHPUnit2_Framework_TestResult  $testResult
     * @access public
     */
    public function runTest(PHPUnit2_Framework_Test $test, PHPUnit2_Framework_TestResult $result) {
        $test->run($result);
    }

    /**
     * Sets the name of the suite.
     *
     * @param  string
     * @access public
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the test at the given index.
     *
     * @param  integer
     * @return PHPUnit2_Framework_Test
     * @access public
     */
    public function testAt($index) {
        if (isset($this->tests[$index])) {
            return $this->tests[$index];
        } else {
            return FALSE;
        }
    }

    /**
     * Returns the number of tests in this suite.
     *
     * @return integer
     * @access public
     */
    public function testCount() {
        return sizeof($this->tests);
    }

    /**
     * Returns the tests as an enumeration.
     *
     * @return array
     * @access public
     */
    public function tests() {
        return $this->tests;
    }

    /**
     * @param  ReflectionMethod $method
     * @param  array            $names
     * @param  ReflectionClass  $theClass
     * @access private
     */
    private function addTestMethod(ReflectionMethod $method, &$names, ReflectionClass $theClass) {
        $name = $method->getName();

        if (in_array($name, $names)) {
            return;
        }

        if ($this->isPublicTestMethod($method)) {
            $names[] = $name;

            $this->addTest(
              self::createTest(
                $theClass,
                $name
              )
            );
        }

        else if ($this->isTestMethod($method)) {
            $this->addTest(
              self::warning(
                sprintf(
                  'Test method is not public: %s',

                  $name
                )
              )
            );
        }
    }

    /**
     * @param  ReflectionMethod $method
     * @return boolean
     * @access private
     */
    private function isPublicTestMethod(ReflectionMethod $method) {
        return ($this->isTestMethod($method) &&
                $method->isPublic());
    }

    /**
     * @param  ReflectionMethod $method
     * @return boolean
     * @access private
     */
    private function isTestMethod(ReflectionMethod $method) {
        return (substr($method->name, 0, 4) == 'test');
    }

    /**
     * @param  string  $message
     * @return PHPUnit2_Framework_Warning
     * @access private
     */
    private static function warning($message) {
        require_once 'PHPUnit2/Framework/Warning.php';
        return new PHPUnit2_Framework_Warning($message);
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
