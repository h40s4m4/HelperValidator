# APIValidatorBundle

This bundle provides various tools and shortcuts to validate and normalize incoming values from an API (and other validations you might need in different places).

## _Validators_

Validators are static functions that can be used in various situations where it is necessary to validate if an incoming data is valid or not. For example, to validate that an incoming data is an INT and not something else.

The validators will return a BOOLEAN value depending on whether the input data is valid or not.

It is also possible to add the `hardException = true` flag to throw an `InvalidArgumentException` exception.