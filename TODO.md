* Validate that assignment variable names do not have the same name as an http request (for controllers).
* Make sure to modify the variable names when adding code in classes.
* Make sure only a small subset of php functions are whitelisted in the custom methods.
* Standardize the way we create namespaces.

* When there is a method that returns a nullable array, make the method with an 's' (ex: getRoles()) in the interface.  Also, add the has* methods in both the interfaces and classes.


possible instructions:

"retrieve": {
    "pattern": "/\\/[a-z]+/s",
    "input": "input",
    "constants": {
        "role_title": "This is a role"
    },
    "http_requests": {
        "retrieve_from_github": {
            "command": "retrieve http://github.com/myuri:80",
            "parameters": {
                "query": {
                    "api_key": "[github_api_key]",
                    "name": "input->name",
                    "another": "my_value"
                }
            },
            "view": "json"
        },
        "insert_user_in_github": {
            "command": "insert http://github.com/myuri:80",
            "parameters": {
                "query": {
                    "another": "my_value"
                },
                "request": {
                    "name": "input->name"
                }
            },
            "headers": {
                "api_key": "[github_api_key]"
            },
            "view": "json"
        },
        "delete_user_in_github": {
            "command": "delete http://github.com/myuri:80",
            "parameters": {
                "query": {
                    "another": "my_value"
                },
                "request": {
                    "name": "input->name"
                }
            },
            "headers": {
                "api_key": "[github_api_key]"
            },
            "view": "json"
        }
    },
    "instructions": [
        "githubData = execute retrieve_from_github",
        "github = from githubData to endpoint",
        "role = retrieve role by uuid:input->uuid",
        "roleData = from role to data",
        "roleAgain = from roleData to role",
        "secondGithubData = from github to data",
        "merged = merge roleData, secondGithubData",

        "execute insert_user_in_github",
        "execute delete_user_in_github",

        "roles = retrieve role index input->min amount input->max",
        "anotherRole = retrieve role by title:constants->role_title",
        "multipleRoles = retrieve multiple role by uuid:input->uuids",
        "anotherMultipleRoles = retrieve multiple role by input->keyname:input->value",

        "roleToo = from input to role",
        "insert roleToo",
        "delete roleToo",

        "rolesAgain = from input to multiple role",
        "insert rolesAgain",
        "delete rolesAgain, roleToo",
        "insert rolesAgain, roleToo",

        "newRole = from input to role",
        "oldRole = retrieve role by uuid:input->uuid",
        "update oldRole using newRole",
        "output = from newRole to data",
        "return merge secondGithubData, output",
        "return output"
    ],
    "view": "json"
}












"delete": {
    "pattern": "delete /$container$/$[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}|uuid$",
    "input": "input",
    "instructions": [
        "entity = retrieve input->container by uuid:input->uuid",
        "delete entity",
        "output = from entity to data",
        "return output"
    ],
    "view": "json",
    "tests": [
        [
            "samples = from this to multiple entity",
            "insert samples",
            [
                [
                    "entity = retrieve this|container by uuid:this->uuid",
                    "delete entity",
                    "retrieve this|container by uuid:this->uuid | not found"
                ]
            ]
        ]
    ]
},
"insert": {
    "pattern": "insert /$container$",
    "input": "input",
    "instructions": [
        "entity = from input to input->container",
        "insert entity",
        "output = from entity to data",
        "return output"
    ],
    "view": "json",
    "tests": [
        [
            [
                [
                    "retrieve this|container by uuid:this->uuid | not found"
                ]
            ]
        ],
        [
            [
                [
                    "sample = from this to entity",
                    "insert sample",
                    "entity = retrieve this|container by uuid:this->uuid",
                    "data = from entity to data",
                    "compare data to this"
                ]
            ]
        ]
    ]
},
"insert_in_bulk": {
    "pattern": "insert /",
    "input": "input",
    "instructions": [
        "entities = from input to multiple input->container",
        "insert entities",
        "output = from entities to data",
        "return output"
    ],
    "view": "json",
    "tests": [
        [
            [
                [
                    "retrieve this|container by uuid:this->uuid | not found"
                ]
            ]
        ],
        [
            "samples = from this to multiple entity",
            "insert samples",
            [
                [
                    "entity = retrieve this|container by uuid:this->uuid",
                    "data = from entity to data",
                    "compare data to this"
                ]
            ]
        ]
    ]
}
