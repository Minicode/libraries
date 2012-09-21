############################################
Request Class
############################################

Pre-processes global request data, and can filter the unsafe characters

    Dependent : None (Can be used independently)

********************************************
Install It
********************************************
You can use Minicode install command line direct install it

::

    mc install request


********************************************
How to use
********************************************
This library after installation will be Minicode automatic loading, in the Controller directly to create it

::

    $req  = new Request;
    $name = $req->get('name');


********************************************
Public Methods
********************************************

get(string $index, boolean $xss_clean)
===============================================================================================
Fetch an item from the GET array, the function returns FALSE (boolean) if the item you are attempting to retrieve does not exist.

Parameters:

- GET array indexing
- Whether filtering XSS character (default: FALSE)


post(string $index, boolean $xss_clean)
===============================================================================================
Fetch an item from the POST array, the function returns FALSE (boolean) if the item you are attempting to retrieve does not exist.

Parameters:

- POST array indexing
- Whether filtering XSS character (default: FALSE)


server(string $index, boolean $xss_clean)
===============================================================================================
Fetch an item from the SERVER array, the function returns FALSE (boolean) if the item you are attempting to retrieve does not exist.

Parameters:

- SERVER array indexing
- Whether filtering XSS character (default: FALSE)


xss_clean(string $str)
===============================================================================================
Remove unsafe XSS characters, and then return to safe string

Parameters:

- Need to filter the original string


ip_address()
===============================================================================================
Fetch the IP address for the current use, If the IP address is not valid, the function will return an IP of: 0.0.0.0


valid_ip(string $ip)
===============================================================================================
Takes an IP address as input and returns TRUE or FALSE (boolean) if it is valid or not.

Parameters:

- IP address


user_agent()
===============================================================================================
Returns the user agent (web browser) being used by the current user. Returns FALSE if it's not available.


request_headers(boolean $xss_clean)
===============================================================================================
Useful if running in a non-Apache environment where apache_request_headers() will not be supported. Returns an array of headers.

Parameters:

- Whether filtering XSS character (default: FALSE)


get_request_header(string $index, boolean $xss_clean)
===============================================================================================
Returns a single member of the request headers array.

Parameters:

- headers array indexing
- Whether filtering XSS character (default: FALSE)


is_ajax_request()
===============================================================================================
Checks to see if the HTTP_X_REQUESTED_WITH server header has been set, and returns a boolean response.


is_cli_request()
===============================================================================================
Checks to see if the STDIN constant is set, which is a failsafe way to see if PHP is being run on the command line.


method()
===============================================================================================
Return the Request Method