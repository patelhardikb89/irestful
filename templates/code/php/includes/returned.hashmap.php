<?php
{% macro hashMapLine(keyname, element, isLast = false) %}
    '{{ keyname }}' => '{{ element }}'{{ isLast ? '' : ',' }}
{% endmacro %}

{% macro hashMapInstanceLine(keyname, element, signature = '', isLast = false) %}
    '{{ keyname }}' => new \{{ element }}({{ signature|raw }}){{ isLast ? '' : ',' }}
{% endmacro %}

{% macro returnedHashMap(hashmap) %}
    {% if hashmap|length > 0 %}
        {% import _self as fn %}
        {% for keyname, element in hashmap %}
            {{- fn.hashMapLine(keyname, element, loop.last) -}}
        {% endfor %}
    {% endif %}
{% endmacro %}


{% macro returnedHashMapObjects(hashmap) %}
    {% if hashmap|length > 0 %}
        {% import _self as fn %}
        {% for keyname, element in hashmap %}
            {{- fn.hashMapLine(keyname, element, loop.last) -}}
        {% endfor %}
    {% endif %}
{% endmacro %}
