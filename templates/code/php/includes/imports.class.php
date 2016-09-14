<?php
{%- macro generateSignatureVariable(oneParameter, isLast) -%}
    {%- if oneParameter.type.is_array -%}
        {%- if oneParameter.is_optional -%}
            {{- 'array $' -}}{{- oneParameter.name -}}{{- ' = null' -}}{{- isLast ? '' : ', ' -}}
        {%- else -%}
            {{- 'array $' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
        {%- endif -%}
    {%- elseif oneParameter.type.namespace -%}
        {{- oneParameter.type.namespace.name -}}{{- ' $' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
    {%- else -%}
        {{- '$' -}}{{- oneParameter.name -}}{{- isLast ? '' : ', ' -}}
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

{%- macro generateClassProperties(parameters) -%}
    {%- if parameters|length > 0 -%}
        {%- for oneParameter in parameters -%}
            private ${{oneParameter.property}};
        {% endfor %}
    {%- endif -%}
{%- endmacro -%}

{%- macro generateAssignment(parameters) -%}
    {%- if parameters|length > 0 -%}
        {%- for oneParameter in parameters -%}
            $this->{{oneParameter.property}} = ${{ oneParameter.parameter.name -}};
        {% endfor %}
    {%- endif -%}
{%- endmacro -%}

{% macro generateGetters(parameters) %}
    {%- if parameters|length > 0 -%}
        {% for oneParameter in parameters %}
            public function {{oneParameter.method.name}}() {
                return $this->{{oneParameter.property}};
            }
        {% endfor -%}
    {%- endif -%}
{% endmacro %}

{% macro generateCustomMethod(customMethod) %}
    {%- import _self as fn -%}
    public function {{customMethod.name}}({{- fn.generateSignature(customMethod.parameters) -}}) {
        {% for oneSourceCodeLine in customMethod.source_code_lines %}
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

{% macro generateClassAnnotations(annotation) %}
/**
*   @container -> {{annotation.container}}
*/
{% endmacro %}

{% macro generateConstructorAnnotations(annotation) %}
{% if annotation.parameters|length > 0 -%}
{% autoescape false %}
{{ '/**' }}
    {% for oneParameter in annotation.parameters %}
*   @{{oneParameter.flow.property_name}} -> {{oneParameter.flow.method_chain}} -> {{oneParameter.flow.keyname}}{{ ' ' }}

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

        {%- if oneParameter.converter.database -%}
            ** {{oneParameter.converter.database.interface}}::{{oneParameter.converter.database.method}}{{ ' ' }}
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
