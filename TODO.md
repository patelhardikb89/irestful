* Enable cross origin
* Generate the Dockerfile and docker-compose file when necessary.
* Make it possible to add external dependencies using apt-get

* Fix the genration of the phpunit xml file, when using third-party crud apis.
* Fix the composer.json file - src folders mapping, when using third-party crud apis.
* When an object uses a third-party object, tests do not work properly for data -> object -> data, when using third-party crud apis.

* Create a logger that write on files.
* Generate the binary using composer.
* Make sure the generated code is aligned properly.


* Create more factories to not duplicate code.
--------------------
* Validate that assignment variable names do not have the same name as an http request (for controllers).
* Make sure to modify the variable names when adding code in classes.

* When there is a method that returns a nullable array, make the method with an 's' (ex: getRoles()) in the interface.  Also, add the has* methods in both the interfaces and classes.
