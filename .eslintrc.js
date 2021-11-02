module.exports = {
  env: {
    browser: true,
    node: true,
    es6: true,
  },
  
  extends: [
    'plugin:vue/recommended',
    'eslint:recommended',
    'airbnb-base',
  ],
  
  plugins: ['vue'],

  parserOptions: {
    parser: '@babel/eslint-parser',
  },
  
  settings: {
    'import/resolver': 'webpack',
  },
  
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-param-reassign': [
      'error',
      {
        props: true,
        ignorePropertyModificationsFor: [
          'state',
          'user',
        ],
      },
    ],
    'import/prefer-default-export': 0,
    'no-shadow': 0,
    'import/no-unresolved': [0, { caseSensitive: false }],
    'import/no-extraneous-dependencies': [0],
    'linebreak-style': 0,
    'no-trailing-spaces': [1, {
      skipBlankLines: true,
      ignoreComments: true,
    }],
    'arrow-parens': 0,
    indent: 0,
    'max-len': ['error',
      {
        code: 180,
        tabWidth: 2,
        ignoreUrls: true,
        ignoreTemplateLiterals: true,
        ignoreStrings: true,
      },
    ],
    /* 'prettier/prettier': [
      'error',
    ], */
    'vue/attributes-order': [
      'error',
      {
        order: [
          'DEFINITION',
          'CONDITIONALS',
          'LIST_RENDERING',
          'TWO_WAY_BINDING',
          'RENDER_MODIFIERS',
          'EVENTS',
          'GLOBAL',
          'UNIQUE',
          'CONTENT',
          'OTHER_DIRECTIVES',
          'OTHER_ATTR',
        ],
      },
    ],
    'vue/attribute-hyphenation': [
      2, 'never', { ignore: ['custom-prop'] },
    ],
    'vue/require-prop-types': 0,
    camelcase: 'off',
    'consistent-return': 'off',
    'vue/no-parsing-error': ['error', {
      'invalid-first-character-of-tag-name': false,
    }],
    'no-restricted-globals': ['error', 'event'],
    'no-alert': 'off',
  },
};
