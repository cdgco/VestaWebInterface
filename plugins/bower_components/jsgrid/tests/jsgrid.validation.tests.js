$(function() {

    var validators = jsGrid.validators;


    module("validation.validate", {
        setup: function() {
            this.validation = new jsGrid.Validation();
        ***REMOVED***
    ***REMOVED***);

    test("as function", function() {
        var validateFunction = function(value) {
            return value === "test";
        ***REMOVED***;

        deepEqual(this.validation.validate({
            value: "not_test",
            rules: validateFunction
        ***REMOVED***), [undefined]);

        deepEqual(this.validation.validate({
            value: "test",
            rules: validateFunction
        ***REMOVED***), []);
    ***REMOVED***);

    test("as rule config", function() {
        var validateRule = {
            validator: function(value) {
                return value === "test";
            ***REMOVED***,
            message: "Error"
        ***REMOVED***;

        deepEqual(this.validation.validate({
            value: "not_test",
            rules: validateRule
        ***REMOVED***), ["Error"]);

        deepEqual(this.validation.validate({
            value: "test",
            rules: validateRule
        ***REMOVED***), []);
    ***REMOVED***);

    test("as rule config with param", function() {
        var validateRule = {
            validator: function(value, item, param) {
                return value === param;
            ***REMOVED***,
            param: "test",
            message: "Error"
        ***REMOVED***;

        deepEqual(this.validation.validate({
            value: "not_test",
            rules: validateRule
        ***REMOVED***), ["Error"]);

        deepEqual(this.validation.validate({
            value: "test",
            rules: validateRule
        ***REMOVED***), []);
    ***REMOVED***);

    test("as array of rules", function() {
        var validateRules = [{
            message: "Error",
            validator: function(value) {
                return value !== "";
            ***REMOVED***
        ***REMOVED***, {
            validator: function(value) {
                return value === "test";
            ***REMOVED***
        ***REMOVED***];

        deepEqual(this.validation.validate({
            value: "",
            rules: validateRules
        ***REMOVED***), ["Error", undefined]);

        deepEqual(this.validation.validate({
            value: "test",
            rules: validateRules
        ***REMOVED***), []);
    ***REMOVED***);

    test("as string", function() {
        validators.test_validator = function(value) {
            return value === "test";
        ***REMOVED***;

        deepEqual(this.validation.validate({
            value: "not_test",
            rules: "test_validator"
        ***REMOVED***), [undefined]);

        deepEqual(this.validation.validate({
            value: "test",
            rules: "test_validator"
        ***REMOVED***), []);

        delete validators.test_validator;
    ***REMOVED***);

    test("as rule config with validator as string", function() {
        validators.test_validator = function(value) {
            return value === "test";
        ***REMOVED***;

        var validateRule = {
            validator: "test_validator",
            message: "Error"
        ***REMOVED***;

        deepEqual(this.validation.validate({
            value: "not_test",
            rules: validateRule
        ***REMOVED***), ["Error"]);

        deepEqual(this.validation.validate({
            value: "test",
            rules: validateRule
        ***REMOVED***), []);

        delete validators.test_validator;
    ***REMOVED***);

    test("as array of mixed rules", function() {
        validators.test_validator = function(value) {
            return value === "test";
        ***REMOVED***;

        var validationRules = [
            "test_validator",
            function(value) {
                return value !== "";
            ***REMOVED***, {
                validator: function(value) {
                    return value === "test";
                ***REMOVED***,
                message: "Error"
            ***REMOVED***
        ];

        deepEqual(this.validation.validate({
            value: "",
            rules: validationRules
        ***REMOVED***), [undefined, undefined, "Error"]);

        deepEqual(this.validation.validate({
            value: "not_test",
            rules: validationRules
        ***REMOVED***), [undefined, "Error"]);

        deepEqual(this.validation.validate({
            value: "test",
            rules: validationRules
        ***REMOVED***), []);

        delete validators.test_validator;
    ***REMOVED***);

    test("as string validator with default error message", function() {
        validators.test_validator = {
            message: function(value) {
                return "Error: " + value;
            ***REMOVED***,
            validator: function(value) {
                return value === "test";
            ***REMOVED***
        ***REMOVED***;

        var validateRule = {
            validator: "test_validator"
        ***REMOVED***;

        deepEqual(this.validation.validate({
            value: "not_test",
            rules: validateRule
        ***REMOVED***), ["Error: not_test"]);

        deepEqual(this.validation.validate({
            value: "test",
            rules: validateRule
        ***REMOVED***), []);

        delete validators.test_validator;
    ***REMOVED***);

    test("throws exception for unknown validator", function() {
        var validateRule = {
            validator: "unknown_validator"
        ***REMOVED***;

        var validation = this.validation;

        throws(function() {
            validation.validate({
                value: "test",
                rules: validateRule
            ***REMOVED***);
        ***REMOVED***, /unknown validator "unknown_validator"/, "exception for unknown validator");
    ***REMOVED***);


    module("validators", {
        setup: function() {
            var validation = new jsGrid.Validation();

            this.testValidator = function(validator, value, param) {
                var result = validation.validate({
                    value: value,
                    rules: { validator: validator, param: param ***REMOVED***
                ***REMOVED***);

                return !result.length;
            ***REMOVED***
        ***REMOVED***
    ***REMOVED***);

    test("required", function() {
        equal(this.testValidator("required", ""), false);
        equal(this.testValidator("required", undefined), false);
        equal(this.testValidator("required", null), false);
        equal(this.testValidator("required", 0), true);
        equal(this.testValidator("required", "test"), true);
    ***REMOVED***);

    test("rangeLength", function() {
        equal(this.testValidator("rangeLength", "123456", [0, 5]), false);
        equal(this.testValidator("rangeLength", "", [1, 5]), false);
        equal(this.testValidator("rangeLength", "123", [0, 5]), true);
        equal(this.testValidator("rangeLength", "", [0, 5]), true);
        equal(this.testValidator("rangeLength", "12345", [0, 5]), true);
    ***REMOVED***);

    test("minLength", function() {
        equal(this.testValidator("minLength", "123", 5), false);
        equal(this.testValidator("minLength", "12345", 5), true);
        equal(this.testValidator("minLength", "123456", 5), true);
    ***REMOVED***);

    test("maxLength", function() {
        equal(this.testValidator("maxLength", "123456", 5), false);
        equal(this.testValidator("maxLength", "12345", 5), true);
        equal(this.testValidator("maxLength", "123", 5), true);
    ***REMOVED***);

    test("pattern", function() {
        equal(this.testValidator("pattern", "_13_", "1?3"), false);
        equal(this.testValidator("pattern", "13", "1?3"), true);
        equal(this.testValidator("pattern", "3", "1?3"), true);
        equal(this.testValidator("pattern", "_13_", /1?3/), true);
    ***REMOVED***);

    test("range", function() {
        equal(this.testValidator("range", 6, [0, 5]), false);
        equal(this.testValidator("range", 0, [1, 5]), false);
        equal(this.testValidator("range", 3, [0, 5]), true);
        equal(this.testValidator("range", 0, [0, 5]), true);
        equal(this.testValidator("range", 5, [0, 5]), true);
    ***REMOVED***);

    test("min", function() {
        equal(this.testValidator("min", 3, 5), false);
        equal(this.testValidator("min", 5, 5), true);
        equal(this.testValidator("min", 6, 5), true);
    ***REMOVED***);

    test("max", function() {
        equal(this.testValidator("max", 6, 5), false);
        equal(this.testValidator("max", 5, 5), true);
        equal(this.testValidator("max", 3, 5), true);
    ***REMOVED***);

***REMOVED***);
