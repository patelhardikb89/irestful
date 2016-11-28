<?php
{%- macro generateSignatureVariable(oneParameter, isLast) -%}
    {%- if oneParameter.type.is_array -%}
        {%- if oneParameter.is_optional -%}
            {{- 'array $' -}}{{- oneParameter.name -}}{{- ' = null' -}}{{- isLast ? '' : ', ' -}}
        {%- else -%}
            {{- 'array $' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
        {%- endif -%}
    {%- elseif oneParameter.type.namespace -%}
        {%- if oneParameter.is_optional -%}
            {{- oneParameter.type.namespace.name -}}{{- ' $' -}}{{- oneParameter.name -}}{{- ' = null' -}}{{- isLast ? '' : ', ' -}}
        {%- else -%}
            {{- oneParameter.type.namespace.name -}}{{- ' $' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
        {%- endif -%}
    {%- elseif oneParameter.type.primitive.is_string -%}
        {%- if oneParameter.is_optional -%}
            string {{- ' $' -}}{{- oneParameter.name -}}{{- ' = null' -}}{{- isLast ? '' : ', ' -}}
        {%- else -%}
            string {{- ' $' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
        {%- endif -%}
    {%- elseif oneParameter.type.primitive.is_boolean -%}
        {%- if oneParameter.is_optional -%}
            bool {{- ' $' -}}{{- oneParameter.name -}}{{- ' = null' -}}{{- isLast ? '' : ', ' -}}
        {%- else -%}
            bool {{- ' $' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
        {%- endif -%}
    {%- elseif oneParameter.type.primitive.is_integer -%}
        {%- if oneParameter.is_optional -%}
            int {{- ' $' -}}{{- oneParameter.name -}}{{- ' = null' -}}{{- isLast ? '' : ', ' -}}
        {%- else -%}
            int {{- ' $' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
        {%- endif -%}
    {%- elseif oneParameter.type.primitive.is_float -%}
        {%- if oneParameter.is_optional -%}
            float {{- ' $' -}}{{- oneParameter.name -}}{{- ' = null' -}}{{- isLast ? '' : ', ' -}}
        {%- else -%}
            float {{- ' $' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
        {%- endif -%}
    {%- else -%}
        {%- if oneParameter.is_optional -%}
            {{- '$' -}}{{- oneParameter.name -}}{{- ' = null' -}}{{- isLast ? '' : ', ' -}}
        {%- else -%}
            {{- '$' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
        {%- endif -%}
    {%- endif -%}
{%- endmacro -%}

{%- macro generateSignature(parameters) -%}
    {%- import _self as fn -%}
    {%- if parameters|length > 0 -%}
        {%- for oneParameter in parameters -%}
            {%- if oneParameter.name != 'current' -%}
                {{- fn.generateSignatureVariable(oneParameter, loop.last) -}}
            {%- endif -%}
        {%- endfor -%}
    {%- endif -%}
{%- endmacro -%}

{%- macro generateConstructorSignature(parameters, hasForwardComma = false) -%}
    {%- import _self as fn -%}
    {%- if parameters|length > 0 -%}
        {{- hasForwardComma ? ', ' : '' -}}{%- for oneParameter in parameters -%}
            {{- fn.generateSignatureVariable(oneParameter.parameter, loop.last) -}}
        {%- endfor -%}
    {%- endif -%}
{%- endmacro -%}

{%- macro generateConstructorInstanciationSignature(parameters) -%}
    {%- import _self as fn -%}
    {%- if parameters|length > 0 -%}
        {%- for oneParameter in parameters -%}
            {{- '$' -}}{{- oneParameter.parameter.name -}}{{- loop.last ? '' : ', ' -}}
        {%- endfor -%}
    {%- endif -%}
{%- endmacro -%}

{%- macro generateClassProperties(parameters) -%}
    {%- if parameters|length > 0 -%}
        {%- for oneParameter in parameters -%}
            private ${{oneParameter.property.name}};
        {% endfor %}
    {%- endif -%}
{%- endmacro -%}

{%- macro generateAssignment(parameters) -%}
    {%- if parameters|length > 0 -%}
        {%- for oneParameter in parameters -%}
            $this->{{oneParameter.property.name}} = ${{ oneParameter.parameter.name -}};
        {% endfor %}
    {%- endif -%}
{%- endmacro -%}

{% macro generateGetters(parameters) %}
    {%- if parameters|length > 0 -%}
        {% for oneParameter in parameters %}
            public function {{oneParameter.method.name}}() {
                return $this->{{oneParameter.property.name}};
            }
        {% endfor -%}
    {%- endif -%}
{% endmacro %}

{% macro generateCustomMethod(customMethod) %}
    {%- import _self as fn -%}
    public function {{customMethod.name}}({{- fn.generateSignature(customMethod.parameters) -}}) {
        {% for oneSourceCodeLine in customMethod.source_code.lines %}
            {{- oneSourceCodeLine|replace({'$current->': '$this->'})|raw }}
        {% endfor -%}
    }
{% endmacro %}

{% macro generateCustomMethods(customMethods) %}
    {%- import _self as fn -%}
    {%- if customMethods|length > 0 -%}
        {% for oneCustomMethod in customMethods %}
            {{ fn.generateCustomMethod(oneCustomMethod) }}
        {% endfor -%}
    {%- endif -%}
{% endmacro %}

{% macro generateConstructorCustomMethod(constructor) %}
    {%- import _self as fn -%}
    {%- if constructor.custom_method -%}
        ${{constructor.custom_method.name}} = function({{- fn.generateSignature(constructor.custom_method.parameters) -}}) {
            {% for oneSourceCodeLine in constructor.custom_method.source_code.lines %}
                {{- oneSourceCodeLine|replace({'\\Exception': 'TypeException'})|raw }}
            {% endfor -%}
        };

        ${{constructor.custom_method.name}}({{- fn.generateConstructorInstanciationSignature(constructor.parameters) -}});
    {%- endif -%}

{% endmacro %}

{% macro generateClassAnnotations(annotation) %}
/**
*   @container -> {{annotation.container_name}}
*/
{% endmacro %}

{% macro generateConstructorAnnotationParameters(annotationParameters) %}
{% if annotationParameters|length > 0 -%}
{% autoescape false %}
{{ '/**' }}
    {% for oneParameter in annotationParameters %}
*   @{{oneParameter.flow.property_name}} -> {{oneParameter.flow.method_chain.chain_as_string}} -> {{oneParameter.flow.keyname}}{{ ' ' }}

        {%- if oneParameter.type -%}
            {%- if oneParameter.type.is_unique or oneParameter.type.is_key -%}
                ++{{ ' ' }}
                {%- if oneParameter.type.is_unique -%}
                    @unique{{ ' ' }}
                {%- endif -%}

                {%- if oneParameter.type.is_key -%}
                    @key{{ ' ' }}
                {%- endif -%}
            {%- endif -%}

            {%- if oneParameter.type.database_type -%}
                ## @{{oneParameter.type.database_type.name}}{{ ' ' }}

                {%- for key, value in oneParameter.type.database_type.value -%}
                    {{key}} -> {{value}}{{ ' ' }}
                {%- endfor -%}

            {%- endif -%}
        {%- endif -%}

        {%- if oneParameter.converter.database_converter -%}
            ** {{oneParameter.converter.database_converter.interface_name}}::{{oneParameter.converter.database_converter.method_name}}{{ ' ' }}
        {%- endif -%}

        {%- if oneParameter.elements_type -%}
            ** @elements-type -> {{oneParameter.elements_type}}
        {%- endif -%}
        {{ ' ' }}
    {% endfor %}
{{ '*/' }}
{% endautoescape %}
{% endif %}
{% endmacro %}
