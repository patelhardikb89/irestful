* In the configuration class, the interfaceClassMapper must include objects and types.
* Custom methods must be in the interfaces.
* The Types interfaces must be inside this namespace:  Domain\Types\MyName\MyName and adapters: Domain\Types\MyName\Adapters\MyNameAdapter)
* When there is a method that returns a nullable array, make the method with an 's' (ex: getRoles()) in the interface.  Also, add the has* methods in both the interfaces and classes.
* Custom methods have underscores in classes.  They should all be camel cases.
* The interface methods uses the type on getters, instead of the name of the property.  There shouldnt be any "getString()" method.  There should be "getDescriotion()" methods.
* Some interface methods contains method names with underscores.  They should all be camel cases.
* When a class is not extending a sub class, do not add the 'extends' keyword.
* Add the interface as a 'use namespace' in the classes.
* Generate the composer.json file
* Generate the phpunit.xml.dist file
* Generate the Vagrantfile file
* Generate class code for controller classes.
* Make sure to modify the variable names when adding code in classes.
* Standardize the way we create namespaces.
