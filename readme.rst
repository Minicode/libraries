###################
Minicode Libraries
###################

This is Minicode provide class library collection package, they can perfect union in the Minicode.

The class library mostly from the minicode carefully write, of course, also have comes from other class library inspiration and secondary reconstruction.

Adhering to the minicode only need to need thought, the class library is also independent writing, they can completely independent existence, leave the minicode use, can be used in any where needed, even other framework is also possible.

You don't need to, we also don't recommend you take these all libraries in your project, only take what you need it. Put them in minicode convention directory, and can realize automatic loading.

*********
Autoload
*********

Where can realize automatic loading ?

Your project:

- libraries (recommend)
- models

    If without "libraries" directory, you need to manually create

Core system:

- core (Not recommend in here)
- lib

    If without "lib" directory, you need to manually create

You can also through the configuration file, and add more loading paths, but we do not suggest to do so, because too many path can lead to loading performance decline, and bad maintenance.

If you have a fixed share Minicode system package storage location, you can consider to put the most commonly used class libraries placed to the system package in the "lib" directory.

Note: Only the directory have PHP files can be loaded to them, that they can't like the Git folder contains, because here need to provide a reference for readme or other relevant documents. 

    eg: libraries/Request.php   √

*********
Install
*********

You can also through the command line, for installation operation. This will avoid you hand to download them

The default installation to the system core package, in the "lib" directory

::

    mc install library_name

Installation to specified project, in the "libraries" directory

::

    mc install library_name project_name

Class library name is underlined the naming of style, example

::

    mc install upload_file app