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
 * @version    CVS: $Id: NamePrettifier.php,v 1.2.2.2 2005/12/17 16:04:58 sebastian Exp $
 * @link       http://pear.php.net/package/PHPUnit2
 * @since      File available since Release 2.3.0
 */

/**
 * Prettifies class and method names for use in TestDox documentation.
 *
 * @category   Testing
 * @package    PHPUnit2
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2002-2006 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 2.3.6
 * @link       http://pear.php.net/package/PHPUnit2
 * @since      Class available since Release 2.1.0
 */
class PHPUnit2_Util_TestDox_NamePrettifier {
    /**
     * @var    string
     * @access protected
     */
    protected $prefix = 'Test';

    /**
     * @var    string
     * @access protected
     */
    protected $suffix = 'Test';

    /**
     * Tests if a method is a test method.
     *
     * @param  string  $testMethodName
     * @return boolean
     * @access public
     */
    public function isATestMethod($testMethodName) {
        if (substr($testMethodName, 0, 4) == 'test') {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Prettifies the name of a test class.
     *
     * @param  string  $testClassName
     * @return string
     * @access public
     */
    public function prettifyTestClass($testClassName) {
        $title = $testClassName;

        if ($this->suffix !== NULL &&
            $this->suffix == substr($testClassName, -1 * strlen($this->suffix))) {
            $title = substr($title, 0, strripos($title, $this->suffix));
        }

        if ($this->prefix !== NULL &&
            $this->prefix == substr($testClassName, 0, strlen($this->prefix))) {
            $title = substr($title, strlen($this->prefix));
        }

        return $title;
    }

    /**
     * Prettifies the name of a test method.
     *
     * @param  string  $testMethodName
     * @return string
     * @access public
     */
    public function prettifyTestMethod($testMethodName) {
        $buffer = '';

        $testMethodName = preg_replace('#\d+$#', '', $testMethodName);

        for ($i = 4; $i < strlen($testMethodName); $i++) {
            if ($i > 4 &&
                ord($testMethodName[$i]) >= 65 && 
                ord($testMethodName[$i]) <= 90) {
                $buffer .= ' ' . strtolower($testMethodName[$i]);
            } else {
                $buffer .= $testMethodName[$i];
            }
        }

        return $buffer;
    }

    /**
     * Sets the prefix of test names.
     *
     * @param  string  $prefix
     * @access public
     */
    public function setPrefix($prefix) {
        $this->prefix = $prefix;
    }

    /**
     * Sets the suffix of test names.
     *
     * @param  string  $prefix
     * @access public
     */
    public function setSuffix($suffix) {
        $this->suffix = $suffix;
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
