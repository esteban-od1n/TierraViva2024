/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./public/**/*.js",
        "./templates/**/*.html.twig",

    ],
    theme: {
        colors: {
            'white': '#ffffff',
            'black': '#000000',
            'timber-green': {
                '50': '#f3faf7',
                '100': '#d7f0e5',
                '200': '#b0dfcd',
                '300': '#80c8af',
                '400': '#56ab90',
                '500': '#3c9077',
                '600': '#2e7360',
                '700': '#285d4f',
                '800': '#244b41',
                '900': '#214038',
                '950': '#15352e',
            },
            'lochinvar': {
                '50': '#f1fcfa',
                '100': '#cff8ee',
                '200': '#9ff0de',
                '300': '#68e0ca',
                '400': '#38c9b3',
                '500': '#1fad9a',
                '600': '#189688',
                '700': '#166f66',
                '800': '#165953',
                '900': '#174a46',
                '950': '#072c2a',
            },
            'pistachio': {
                '50': '#f9fce9',
                '100': '#f2f9ce',
                '200': '#e3f3a3',
                '300': '#cee86e',
                '400': '#b8da41',
                '500': '#92b621',
                '600': '#779917',
                '700': '#5a7417',
                '800': '#485c18',
                '900': '#3e4f18',
                '950': '#1f2b08',
            },
            'pancho': {
                '50': '#fcf7f0',
                '100': '#f8eddc',
                '200': '#edcfa9',
                '300': '#e6bc8b',
                '400': '#db985c',
                '500': '#d37d3c',
                '600': '#c56731',
                '700': '#a4512a',
                '800': '#844128',
                '900': '#6a3824',
                '950': '#391b11',
            },
            'buttercup': {
                '50': '#fdf9e9',
                '100': '#fbf1c6',
                '200': '#f9e08f',
                '300': '#f5c74f',
                '400': '#efac19',
                '500': '#e09712',
                '600': '#c1730d',
                '700': '#9a510e',
                '800': '#804113',
                '900': '#6d3516',
                '950': '#3f1a09',
            },
            'kumera': {
                '50': '#f8f5ee',
                '100': '#ede7d4',
                '200': '#ddceab',
                '300': '#caaf7a',
                '400': '#b99456',
                '500': '#aa8148',
                '600': '#865f37',
                '700': '#754f33',
                '800': '#634230',
                '900': '#56392d',
                '950': '#311e17',
            },
        },
        fontFamily: {
            display: ['Langar', 'system-ui'],
            body: ['Roboto Condensed', 'sans-serif'],
            label: ['Oswald', 'sans-serif'],
            heading: ['Lalezar', 'system-ui']
        },
        extend: {
            keyframes: {
                'slide-reveal': {
                    '0%': { transform: 'translate(30px)', opacity: 0 },
                    '100%': { transform: 'translate(0px)', opacity: 1 }
                },
                'smooth-scale': {
                    '0%': { transform: 'scale(1)' },
                    '100%': { transform: 'scale(1.15)' }
                }
            },
        },
    },
    plugins: [],
}

