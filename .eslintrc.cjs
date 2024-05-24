module.exports = {
    parserOptions: {
        project: "./tsconfig.json",
        ecmaVersion: "latest",
    },
    extends: ["airbnb", "airbnb-typescript"],
    env: {
        browser: true,
        node: true,
    },
    ignorePatterns: [".eslintrc.cjs"],
    rules: {
        "max-len": [
            1,
            120,
            2,
            {
                ignoreComments: true,
            },
        ],
        "padded-blocks": "off",
        "@typescript-eslint/return-await": "off",
        "@typescript-eslint/no-use-before-define": "off",
        "@typescript-eslint/indent": ["error", 4],
        indent: [
            "error",
            4,
            {
                ImportDeclaration: 1,
            },
        ],
        "react/jsx-indent": ["error", 4],
        "react/jsx-indent-props": ["error", 4],
        "import/prefer-default-export": "off",
        "func-names": "off",
        quotes: [
            "error",
            "single",
            {
                allowTemplateLiterals: true,
            },
        ],
        "import/extensions": "off",
        "import/no-extraneous-dependencies": [
            "error",
            {
                devDependencies: true,
                optionalDependencies: false,
                peerDependencies: false,
            },
        ],
        "import/no-unresolved": "off",
        "object-shorthand": "off",
        "no-param-reassign": ["error", { props: false }],
        "prefer-destructuring": [
            "error",
            {
                object: false,
                array: false,
            },
        ],
        camelcase: [
            "error",
            {
                ignoreImports: true,
            },
        ],
        "no-shadow": "off",
        "spaced-comment": ["error", "always"],
    },
};
