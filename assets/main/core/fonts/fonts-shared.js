module.exports = {
    check: function() {
        return ('; ' + document.cookie).split('; fonts-loaded=').length === 2;
    },
    loaded: function() {
        document.documentElement.className += ' fonts-loaded';
    }
};
