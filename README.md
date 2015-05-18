# MATM TYPEAHEADBUNDLE

This bundle provides a typeahead input in your symfony forms based on **Twitter Typeahead**.

**THIS VERSION IS NOT STABLE YET BE PATIENT**

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

## FILES TO INCLUDE

In your base.html.twig file (or equivalent), just include
default stylesheet (or you can create your own) :

    {% stylesheets 'bundles/matmtypeahead/css/typeahead.css' %}
        <link href="{{ asset_url }}" type="text/css" rel="stylesheet" />
    {% endstylesheets %}

typeahead bundle js files :

    {% javascripts "@MatMTypeAheadBundle/Resources/public/js/TypeAhead/*" %}
        <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}

## CONFIGURATION

In your config.yml file just add these lines

    # app/config/config.yml
    twig:
        form:
            resources:
                - 'MatMTypeAheadBundle:Form:typeahead-form-theme.html.twig'

## USAGE

In your controller action request your entity repository as you need, then call typeahead dataset maker with your results and choose which properties of your entity you want to use for the search and the display

    // $results = the results of your own query
    // "real_name" = the property of your target entity you want to use for the search
    // "display_name" = the property of your target entity you want to display
    $list = $this->get("mm.dataset_maker")->makeTypeAheadDataset($results, "real_name", "display_name");

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
    $(document).ready(function(){
	    TypeAheadBundle.typeAheadProcessor(list, '.typeahead', 'dataset_name', "#my_form_input_id");
    });

Now all you need to do is to call the typeahead input in your form buider class

    $builder->add(
        'myProperty',
        'typeahead',
        array(
            "data_class" => 'Path\ToMy\Bundle\Entity\MyEntity',
            'label'    => 'my_label',
            'attr' => array("display" => "name"), //this one is needed to transform the displayed value in case of hydrated form
        )
    )

Et voilà!

