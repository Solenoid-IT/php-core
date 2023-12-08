// © Solenoid Team



if ( typeof Solenoid === 'undefined' ) Solenoid = {};

if ( typeof Solenoid.SWG === 'undefined' ) Solenoid.SWG = {};



Solenoid.SWG.Form = function (element, inputNameSeparator, invalidInputClass)
{
    const private = {};
    const public  = this;



    // Returns [void]
    private.parseDotNotation = function (str, val, obj, separator)
    {
        let currentObj = obj,
            keys = str.split(separator),
            i, l = Math.max(1, keys.length - 1),
            key;
    
        for (i = 0; i < l; ++i) {
            key = keys[i];
            currentObj[key] = currentObj[key] || {};
            currentObj = currentObj[key];
        }
    
        currentObj[keys[i]] = val;
        delete obj[str];
    }
    ;
    
    // Returns [object]
    private.objectExpand = function (object, separator)
    {
        for (const key in object)
        {// Processing each entry
            if (key.indexOf(separator) !== -1)
            {// Match OK
                // (Parsing the dot notation)
                private.parseDotNotation(key, object[key], object, separator);
            }            
        }
    
    
    
        // Returning the value
        return object;
    }
    ;

    // Returns [object]
    private.objectCompress = function (object, separator)
    {
        // (Setting the value)
        let output = {};

        for (const i in object)
        {// Processing each entry
            if (!object.hasOwnProperty(i))
            {// Match failed
                // Continuing the iteration
                continue;
            }



            if ((typeof object[i]) === 'object' && object[i] !== null && !(object[i] instanceof Array))
            {// Match OK
                // (Calling the function)
                let currentObject = private.objectCompress(object[i], separator);

                for (const x in currentObject)
                {// Processing each entry
                    if (!currentObject.hasOwnProperty(x))
                    {// Match failed
                        // Continuing the iteration
                        continue;
                    }
    


                    // (Getting the value)
                    output[i+separator+x] = currentObject[x];
                }
            }
            else
            {// Match failed
                // (Getting the value)
                output[i] = object[i];
            }
        }



        // Returning the value
        return output;
    }



    private.__construct = function (element, inputNameSeparator)
    {
        // (Setting the value)
        private.eventCallbacks = {};

        // (Getting the values)
        public.element            = element;

        public.inputNameSeparator = typeof inputNameSeparator === 'undefined' ? '.' : inputNameSeparator;
        public.invalidInputClass  = typeof invalidInputClass === 'undefined' ? 'input-invalid' : invalidInputClass;



        // (Listening for the event)
        element.addEventListener('submit', function (event) {
            // (Preventing the default)
            event.preventDefault();

            // (Triggering the event)
            public.triggerEvent('submit', event);
        });
    }



    // Returns [void]
    public.addEventListener = function (type, callback)
    {
        if ( typeof private.eventCallbacks[ type ] === 'undefined' ) private.eventCallbacks[ type ] = [];



        // Appending the value
        private.eventCallbacks[ type ].push( callback );
    }

    // Returns [void]
    public.triggerEvent = function (type, data)
    {
        if ( typeof private.eventCallbacks[ type ] === 'undefined' ) return;



        for (const callback of private.eventCallbacks[ type ])
        {// Processing each entry
            // (Calling the function)
            callback( data );
        }
    }



    // Returns [void]
    public.reset = function ()
    {
        // (Iterating each entry)
        public.element.querySelectorAll('.input:not(.input-ignore)').forEach
        (
            function (inputElement)
            {
                // (Setting the value)
                inputElement.value = '';
            }
        )
        ;
    }

    // Returns [object]
    public.getInput = function (mode)
    {
        if ( typeof mode === 'undefined' ) mode = 'value';



        // (Setting the value)
        let input = {};

        // (Iterating each entry)
        public.element.querySelectorAll('.input:not(.input-ignore)').forEach
        (
            function (inputElement)
            {
                // (Setting the value)
                let inputValue = null;

                switch ( inputElement.getAttribute('type') )
                {
                    case 'checkbox':
                        // (Getting the value)
                        inputValue = inputElement.checked;
                    break;

                    default:
                        // (Getting the value)
                        inputValue = inputElement.value;
                }



                // (Getting the value)
                input[ inputElement.getAttribute('name') ] =
                    mode === 'value'
                        ?
                    inputValue
                        :
                    {
                        'element': inputElement,
                        'value':   inputValue
                    }
                ;
            }
        )
        ;

        // (Getting the value)
        input = private.objectExpand( input, public.inputNameSeparator );



        // Returning the value
        return input;
    }



    // Returns [object]
    public.validate = function (display)
    {
        if ( typeof display === 'undefined' ) display = false;



        // (Setting the values)
        let input        = {};
        let firstInvalid = false;

        // (Iterating each entry)
        public.element.querySelectorAll('.input:not(.input-ignore)[data-required]').forEach
        (
            function (inputElement)
            {
                // (Getting the values)
                const regex = inputElement.getAttribute('data-regex');
                const valid = regex ? ( new RegExp( regex ).test( inputElement.value ) ) : ( inputElement.value.length === 0 ? false : true );

                if ( !valid )
                {// (Input is not valid)
                    if ( !firstInvalid )
                    {// Match OK
                        // (Setting the value)
                        firstInvalid = true;

                        if ( display )
                        {// Value is true
                            // (Focusing the element)
                            inputElement.focus();
                        }
                    }



                    // (Setting the value)
                    input[ inputElement.getAttribute('name') ] = inputElement;
                }



                if ( display )
                {// Value is true
                    // (Calling the function)
                    inputElement.classList[ valid ? 'remove' : 'add' ]( public.invalidInputClass );
                }
            }
        )
        ;



        // Returning the value
        return input;
    }



    private.__construct( element, inputNameSeparator );
}
;



// (Listening for the event)
window.addEventListener('load', function () {
    // (Appending the value)
    const styleElement = document.createElement('style');

    // (Setting the html content)
    styleElement.innerHTML =
        `
            .swg.swg-form .input.is-invalid,
            .swg.swg-form .input.input-invalid
            {
                border-color: #dc3545 !important;
                padding-right: calc(1.5em + .75rem) !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
                background-repeat: no-repeat !important;
                background-position: right calc(.375em + .1875rem) center !important;
                background-size: calc(.75em + .375rem) calc(.75em + .375rem) !important;
            }
            
            .swg.swg-form .input.is-invalid:focus,
            .swg.swg-form .input.input-invalid:focus
            {
                box-shadow: 0 0 0 .2rem rgba(220,53,69,.25) !important;
            }
        `
    ;



    // (Appending the element)
    document.head.appendChild( styleElement );
});