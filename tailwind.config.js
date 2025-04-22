import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Instrument Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {

                'welcome': {
                    'bg-light': '#FDFDFC',
                    'bg-dark': '#0a0a0a',
                    'text-light': '#1b1b18',
                    'text-dark': '#EDEDEC',
                    'text-secondary-light': '#706f6c', 
                    'text-secondary-dark': '#A1A09A',  
                    'accent-light': '#F53003',       
                    'accent-dark': '#FF4433',        
                    'border-light': '#e3e3e0',       
                    'border-dark': '#3E3E3A',        
                    'button-bg-light': '#1b1b18',    
                    'button-text-light': '#ffffff',  
                    'button-bg-dark': '#eeeeec',     
                    'button-text-dark': '#1C1C1A',   
                }
            },
        },
    },

    plugins: [forms],
};