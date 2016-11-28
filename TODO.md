* Enable combos in code generation.
* Generate the .gitignore file.
*
* Make sure we have objects or container.  1 of them is mandatory.  Cannot be both empty.
* Enable cross origin
* Remove duplicate interfaces in classes, when 2 parameters have the same type.
* Enable importing static data on install

* Fix the genration of the phpunit xml file, when using third-party crud apis.
* Fix the composer.json file - src folders mapping, when using third-party crud apis.
* When an object uses a third-party object, tests do not work properly for data -> object -> data, when using third-party crud apis.

* Create a logger that write on files.
* Create an application
* Generate the binary using composer.
* Make sure the generated code is aligned properly.
* Generate the Dockerfile and docker-compose file when necessary.

* Add the CLI params
* Create more factories to not duplicate code.
--------------------
* Validate that assignment variable names do not have the same name as an http request (for controllers).
* Make sure to modify the variable names when adding code in classes.

* When there is a method that returns a nullable array, make the method with an 's' (ex: getRoles()) in the interface.  Also, add the has* methods in both the interfaces and classes.
