############################################
Session Class
############################################

Session management class, has struck the function such as data. To provide a uniform interface, so that after session storage mechanism of expansion and replacement, and will not affect your code

    Dependent : None (Can be used independently)

********************************************
Install It
********************************************
You can use Minicode install command line direct install it

::

    mc install session


********************************************
How to use
********************************************
This library after installation will be Minicode automatic loading, in the Controller directly to create it

::

    $sess  = new Session;
    $sess->set_data('logged_in', TRUE);


********************************************
Public Methods
********************************************

data(string $item)
===============================================================================================
Retrieving Session Data, The function returns FALSE (boolean) if the item you are trying to access does not exist.

Where item is the array index corresponding to the item you wish to fetch. For example, to fetch the session ID you will do this:

::

    $session_id = $sess->data('session_id');


set_data(mixed $array, string $value)
===============================================================================================
A useful aspect of the session array is that you can add your own data to it and it will be stored in the user's session. Why would you want to do this? Here's one example:

::

    $user_data  = array('username'  => 'john', 'email' => 'john@xxx.com', 'logged_in' => TRUE);
    $sess->set_data($user_data);

If you want to add userdata one value at a time, set_data() also supports this syntax.

::

    $sess->set_data('username', 'john');

unset_data(mixed $index)
===============================================================================================
Just as set_userdata() can be used to add information into a session, unset_userdata() can be used to remove it, by passing the session key. For example, if you wanted to remove 'some_name' from your session information:

::

    $sess->unset_data('username');

This function can also be passed an associative array of items to unset:

::

    $remove_items = array('username' => '', 'email' => '');
    $sess->unset_data($remove_items);


flashdata(string $item)
===============================================================================================
The class supports "flashdata", or session data that will only be available for the next server request, and are then automatically cleared. These can be very useful, and are typically used for informational or status messages (for example: "Password is not correct").

You can also pass an array to set_flashdata(), in the same manner as set_data().
To read a flashdata variable:

::

    $sess->flashdata('error');


set_flashdata(string $item, string $value)
===============================================================================================
To add flashdata:

::

    $sess->set_flashdata('error', 'Password is not correct');


keep_flashdata(string $item)
===============================================================================================
If you find that you need to preserve a flashdata variable through an additional request, you can do so using the keep_flashdata() function.

::

    $sess->keep_flashdata('error');