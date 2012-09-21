############################################
UploadFile Class
############################################

Provides file upload, it can filter file type, restricted upload size and the function of the rich.

    Dependent : None (Can be used independently)

********************************************
Install It
********************************************
You can use Minicode install command line direct install it

::

    mc install upload_file


********************************************
How to use
********************************************
This library after installation will be Minicode automatic loading, in the Controller directly to create it

::

    $upd = new UploadFile;
    $upd->set_field('file');
    $upd->set_upload_path('./uploads');
    $upd->upload();


********************************************
Public Methods
********************************************

set_field(string $field)
===============================================================================================
Setting file upload form the field name.

Parameters:

- Input file form the field name


set_upload_path(string $path)
===============================================================================================
File upload directory, and can be absolute path, also can be relative path (relative to the entry documents)

Parameters:

- File upload directory


set_max_size(int $size)
===============================================================================================
Limit the size of the file upload. No limit is 0, but cannot exceed the limitation of the PHP configuration.

Parameters:

- Limit the size (default: 0)


set_allowed_types(array $types)
===============================================================================================
Limit file upload types, namely name suffix.

Parameters:

- Limit file upload types (default: array('gif', 'jpg', 'png'))

Example:

::

    $upd->set_allowed_types(array('zip', 'rar', 'gif', 'jpg', 'png'));


set_sub_dir(string $dir)
===============================================================================================
If need be, can set upload directory of subdirectories.

Parameters:

- Subdirectory

Example:

::

    $upd->set_sub_dir(date('Ymd'));


upload()
===============================================================================================
Ready? executive upload.
Uploaded successfully return relevant data array, failure return FALSE.


error()
===============================================================================================
Get a upload failure of the error message.