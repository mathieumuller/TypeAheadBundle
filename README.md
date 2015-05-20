# MATM TYPEAHEADBUNDLE

This bundle provides a typeahead input in your symfony forms based on **Twitter Typeahead**.

## INSTALLATION

With composer, add the following line to your composer.json

    {
        "require": {
            "matm/typeaheadbundle": "dev-master"
        }
    }

And don't forget to enable it in you kernel

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            //...
            new MatM\Bundle\TypeAheadBundle\MatMTypeAheadBundle(),
            //...

## CONFIGURATION

In your config.yml file just add these lines

    # app/config/config.yml
    twig:
        form:
            resources:
                - 'MatMTypeAheadBundle:Form:typeahead-form-theme.html.twig'
    ...
    framework:
        templating:
            packages:
            cdnjs:
                base_urls:
                    http: ['https://cdnjs.cloudflare.com/ajax/libs/']

## FILES TO INCLUDE

In your base.html.twig file (or equivalent), just include
default stylesheet (or you can create your own) :

    {% stylesheets 'bundles/matmtypeahead/css/typeahead.css' %}
        <link href="{{ asset_url }}" type="text/css" rel="stylesheet" />
    {% endstylesheets %}

typeahead bundle js files :

    <script src="{{ asset('typeahead.js/0.11.1/typeahead.bundle.js', 'cdnjs') }}"></script>
    {% javascripts "@MatMTypeAheadBundle/Resources/public/js/TypeAhead/TypeAheadBundle.js" %}
        <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}

## USAGE

In your controller action request your entity repository as you need, then call typeahead dataset maker with your results and choose which properties of your entity you want to use for the search and the display

    // $results = the results of your own query
    // "search_method" = the method of your target entity you want to use for the search
    // "display_method" = the method of your target entity you want to use for the display
    $list = $this->get("matm.dataset_maker")->makeTypeAheadDataset($results, "search_method", "display_method");

Then pass the list to your template

    return $this->render(
        'MyBundle:MyController:my_template.html.twig',
        array(
            'form' => $form->createView(),
            'list' => $list
        )
    );

And finally create a JS variable with it in your template

    {% block javascripts %}
        <script>
             var list = {{ list | json_encode | raw }};
        </script>
    {% endblock %}

In a JS file declare a document ready :

    //list : your data list
    //dataset_name : choose a name for your dataset
    //#my_form_input_id : the id of the form input
    // onSelectFunction : not mandatory->the function you wish to execute on value selection
    $(document).ready(function(){
	    TypeAheadBundle.typeAheadProcessor(list, "#my_form_input_id", onSelectFunction);
    });

Now all you need to do is to call the typeahead input in your form buider class

    $builder->add(
        'myProperty',
        'typeahead',
        array(
            "data_class" => 'Path\ToMy\Bundle\Entity\MyEntity',
            'label'    => 'my_label',
            'attr' => array("display" => "name"), //the property to display in case of hydrated form
        )
    )

You can also use the widget even if you are not using it in a symfony form including it in your twig template

    {% include "MatMTypeAheadBundle::matm_typeahead.html.twig" with {id: "choose_an_id", placeholder: 'choose_a_placeholder')} %}

Et voilà!

