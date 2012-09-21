<?php
/**
 * Minicode - only need to need!
 *
 * An open source hyper-light web application agile development framework
 *
 * @package       Minicode
 * @author        Wanglong
 * @copyright     Copyright (c) 2012 - 2013, Minicode.
 * @license       http://minicode.org/docs/license
 * @link          http://minicode.org
 */

// ------------------------------------------------------------------------

/**
 * Native Session Class
 *
 * Session management class, has struck the function such as data. 
 * To provide a uniform interface, so that after session storage mechanism 
 * of expansion and replacement, and will not affect your code.
 *
 * @package       Minicode
 * @category      Libraries
 * @subpackage    Session
 * @author        Wanglong
 * @link          http://minicode.org/docs/libraries/session
 * @version       1.0
 */

class Session {

    /**
     * The number of SECONDS you want the session to last.
     * by default sessions last 7200 seconds (two hours).  
     * Set to zero for no expiration.    
     *
     * Note: session expiration and not index according to 
     * the lost , but change new session storage, the old 
     * session destroy, data remain keeping.
     *
     * So this value can be used to keep data persistent, 
     * the smaller the value, the higher the frequency data 
     * more persistent, because Session GC recovery is global  
     * by random. You should timely create a new session.
     *
     * @access private
     * @var    string
     */
    private $expiration = 7200;

    // --------------------------------------------------------------------

    /**
     * Prefix for "flash" variables (eg. flash:new:message)
     *
     * @access private
     * @var    string
     */
    private $flash_key  = 'flash';

    // --------------------------------------------------------------------

    /**
     * Constructor
     *
     * @access  public
     * @param   array   $options
     * @return  void
     */
    public function __construct($options = array()) {

        if ( ! empty($options['expire'])) {
            $this->expiration = (int) $options['expire'] <= 0 ? (60*60*24*365*2) : $options['expire'];
        }

        ini_set('session.gc_maxlifetime', $this->expiration);

        $this->main();
    }

    // --------------------------------------------------------------------

    /**
     * Reads given session attribute value
     *
     * @access  public
     * @param   string
     * @return    mixed
     */
    public function data($item) {
        // added for backward-compatibility
        if ($item == 'session_id') {
            return session_id();
        }
        else {
            return ( ! isset($_SESSION[$item])) ? FALSE : $_SESSION[$item];
        }
    }

    // --------------------------------------------------------------------

    /**
     * Sets session attributes to the given values
     *
     * @access  public
     * @param   mixed
     * @param   string
     * @return    void
     */
    public function set_data($newdata = array(), $newval = '') {
        if (is_string($newdata)) {
            $newdata = array($newdata => $newval);
        }

        if (count($newdata) > 0) {
            foreach ($newdata as $key => $val) {
                $_SESSION[$key] = $val;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Erases given session attributes
     *
     * @access  public
     * @param   mixed
     * @return    void
     */
    public function unset_data($newdata = array()) {
        if (is_string($newdata)) {
            $newdata = array($newdata => '');
        }

        if (count($newdata) > 0) {
            foreach ($newdata as $key => $val) {
                unset($_SESSION[$key]);
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Returns "flash" data for the given key.
     *
     * @access  public
     * @param   string
     * @return    mixed
     */
    public function flashdata($key) {
        $flash_key = $this->flash_key.':old:'.$key;
        return $this->data($flash_key);
    }

    // --------------------------------------------------------------------

    /**
     * Sets "flash" data which will be available only in next request 
     * (then it will be deleted from session). You can use it to 
     * implement "Save succeeded" messages after redirect.
     *
     * @access  public
     * @param    mixed
     * @param    string
     * @return    void
     */
    public function set_flashdata($newdata = array(), $newval = '') {
        if (is_string($newdata)) {
            $newdata = array($newdata => $newval);
        }

        if (count($newdata) > 0) {
            $flashdata = array();

            foreach ($newdata as $key => $val) {
                $flashdata[$this->flash_key . ':new:' . $key] = $val;
            }

            $this->set_data($flashdata);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Keeps existing "flash" data available to next request.
     *
     * @access  public
     * @param   string
     * @return    void
     */
    public function keep_flashdata($key) {
        $old_flash_key = $this->flash_key.':old:'.$key;
        $value = $this->data($old_flash_key);

        $new_flash_key = $this->flash_key.':new:'.$key;
        $this->set_data($new_flash_key, $value);
    }

    // --------------------------------------------------------------------
    
    /**
     * Destroys the session and erases session storage
     *
     * @access  public
     * @return    void
     */
    public function destroy() {
        unset($_SESSION);
        if ( isset( $_COOKIE[session_name()] ) ) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
    }

    // --------------------------------------------------------------------

    /**
     * Starts up the session system for current request
     *
     * @access  private
     * @return    void
     */
    private function main() {
        session_start();

        // check if session id needs regeneration
        if ( $this->session_id_expired() ) {
            // regenerate session id (session data stays the
            // same, but old session storage is destroyed)
            $this->regenerate_id();
        }

        // delete old flashdata (from last request)
        $this->flashdata_sweep();

        // mark all new flashdata as old (data will be deleted before next request)
        $this->flashdata_mark();
    }

    // --------------------------------------------------------------------

    /**
     * Checks if session has expired
     *
     * @access  private
     * @return    boolean
     */
    private function session_id_expired() {
        if ( !isset($_SESSION['regenerated'])) {
            $_SESSION['regenerated'] = time();
            return FALSE;
        }

        $expiry_time = time() - $this->expiration;

        if ( $_SESSION['regenerated'] <=  $expiry_time ) {
            return TRUE;
        }

        return FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Regenerates session id
     *
     * @access  private
     * @return    void
     */
    private function regenerate_id() {
        // copy old session data, including its id
        $old_session_id = session_id();
        $old_session_data = $_SESSION;

        // regenerate session id and store it
        session_regenerate_id();
        $new_session_id = session_id();

        // switch to the old session and destroy its storage
        session_id($old_session_id);
        session_destroy();

        // switch back to the new session id and send the cookie
        session_id($new_session_id);
        session_start();

        // restore the old session data into the new session
        $_SESSION = $old_session_data;

        // update the session creation time
        $_SESSION['regenerated'] = time();

        // session_write_close() patch based on this thread
        // end the current session and store session data.
        session_write_close();
    }

    // --------------------------------------------------------------------

    /**
     * Marks "flash" session attributes as 'old'
     *
     * @access  private
     * @return    void
     */
    private function flashdata_mark() {
        foreach ($_SESSION as $name => $value) {
            $parts = explode(':new:', $name);
            if (is_array($parts) && count($parts) == 2) {
                $new_name = $this->flash_key.':old:'.$parts[1];
                $this->set_data($new_name, $value);
                $this->unset_data($name);
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Removes "flash" session marked as 'old'
     *
     * @access  private
     * @return    void
     */
    private function flashdata_sweep() {
        foreach ($_SESSION as $name => $value) {
            $parts = explode(':old:', $name);
            if (is_array($parts) && count($parts) == 2 && $parts[0] == $this->flash_key) {
                $this->unset_data($name);
            }
        }
    }
}

// END Session Class
// By Minicode