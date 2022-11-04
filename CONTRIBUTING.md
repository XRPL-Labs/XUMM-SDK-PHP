# Contributing

We'd be very happy to receive your contributions to this SDK! Please see below for contributing guidelines.

## General contributing guidelines

### Issues, bugs, and feature requests
If you find any bugs or want to request a feature, please either:
- open a GitHub issue in the repository with an appropriate label (i.e. `bug`),
- detail what you expect to happen and what is actually happening,
- ideally add a link to the appropriate Xumm API docs (if applicable),
- OR open your own PR :) See below for the development process. 

## Development process
Create a fork of the repo on Github and clone it. Then set up your development
environment:

### Dev environment setup
1. Ensure you have installed the following requirements: 
- PHP 8.1 or higher
- [Composer](https://getcomposer.org/)
- [Docker](https://docs.docker.com/get-docker/) and [docker compose](https://docs.docker.com/compose/install/)
2. In the root of the project, run `composer install` to install dependencies.
3. Start developing! Please refer to our code guidelines below.
4. Run all tests (see below) before you create your PR. Merging will be blocked until they pass.

### Coding guidelines
This package uses PHP 8.1 and strives to use PHP>=8.1 features. Where possible, use strict
argument and return types, and consider using features like enum types where appropriate.

While coding, keep in mind the user of this package. Users interact with the Xumm API through
the `XummSDK` class and the value objects mentioned in the user documentation (such as implementations
of `XummResponse`. They should not interact directly with anything in the client layer or other package
internals, such as `XummClient` or the `Guzzle\XummClient` implementation, the `XummSerializer`, etc.

For **exception handling**, users of the package will expect to be able to catch implementations of
`XummException`. When throwing exceptions, make sure they implement `XummLogicException`, `XummBadResponseException`,
or their base class `XummException`. Please see the `Exception` namespace for examples.

### Running tests
To run all test suites:
`make test`

To run a specific test suite (e.g. unit, acceptance):
```angular2html
make test-{suite}

// e.g.: make test-unit
```

The acceptance test suite runs against the
[XUMM mock API](https://github.com/paulinevos/xumm-mock-api). If you have Docker and docker compose, running `make test`
will spin it up for you. Otherwise, you're free to run it yourself using node. 

Before running the acceptance test suite, `source .env.testing` to set the necessary environment variables.

