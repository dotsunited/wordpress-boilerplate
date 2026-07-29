// Ambient declarations for non-TypeScript assets imported by the bundler.

declare module '*.css';
declare module '*.svg';

declare module 'ctrly/src/ctrly' {
    import ctrly from 'ctrly';

    export default ctrly;
}
