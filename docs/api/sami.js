
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">SehrGut</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:SehrGut_Laravel5_Api" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api.html">Laravel5_Api</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:SehrGut_Laravel5_Api_Exceptions" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Exceptions.html">Exceptions</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:SehrGut_Laravel5_Api_Exceptions_Formatter" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Exceptions/Formatter.html">Formatter</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Formatter_FormatterException" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Formatter/FormatterException.html">FormatterException</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Formatter_InvalidData" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Formatter/InvalidData.html">InvalidData</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Exceptions_Http" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Exceptions/Http.html">Http</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Http_HttpException" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Http/HttpException.html">HttpException</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Http_NotFound" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Http/NotFound.html">NotFound</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Exceptions_Validator" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Exceptions/Validator.html">Validator</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Validator_InvalidInput" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Validator/InvalidInput.html">InvalidInput</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Validator_ValidatorException" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Validator/ValidatorException.html">ValidatorException</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Exception" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Exception.html">Exception</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Formatters" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Formatters.html">Formatters</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Formatters_Formatter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Formatters/Formatter.html">Formatter</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Formatters_JsonapiFormatter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html">JsonapiFormatter</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Controller" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Controller.html">Controller</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_ModelMapping" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/ModelMapping.html">ModelMapping</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_RequestAdapter" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/RequestAdapter.html">RequestAdapter</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Transformer" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Transformer.html">Transformer</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Validator" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Validator.html">Validator</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "SehrGut.html", "name": "SehrGut", "doc": "Namespace SehrGut"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api.html", "name": "SehrGut\\Laravel5_Api", "doc": "Namespace SehrGut\\Laravel5_Api"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Exceptions.html", "name": "SehrGut\\Laravel5_Api\\Exceptions", "doc": "Namespace SehrGut\\Laravel5_Api\\Exceptions"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Exceptions/Formatter.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Formatter", "doc": "Namespace SehrGut\\Laravel5_Api\\Exceptions\\Formatter"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Exceptions/Http.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Http", "doc": "Namespace SehrGut\\Laravel5_Api\\Exceptions\\Http"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Exceptions/Validator.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Validator", "doc": "Namespace SehrGut\\Laravel5_Api\\Exceptions\\Validator"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Formatters.html", "name": "SehrGut\\Laravel5_Api\\Formatters", "doc": "Namespace SehrGut\\Laravel5_Api\\Formatters"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api", "fromLink": "SehrGut/Laravel5_Api.html", "link": "SehrGut/Laravel5_Api/Controller.html", "name": "SehrGut\\Laravel5_Api\\Controller", "doc": "&quot;The main Controler to inherit from.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method___construct", "name": "SehrGut\\Laravel5_Api\\Controller::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_index", "name": "SehrGut\\Laravel5_Api\\Controller::index", "doc": "&quot;Request Handler: List all resources.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_store", "name": "SehrGut\\Laravel5_Api\\Controller::store", "doc": "&quot;Request Handler: Create a new resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_show", "name": "SehrGut\\Laravel5_Api\\Controller::show", "doc": "&quot;Request Handler: Show a single resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_update", "name": "SehrGut\\Laravel5_Api\\Controller::update", "doc": "&quot;Request Handler: Update a resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_destroy", "name": "SehrGut\\Laravel5_Api\\Controller::destroy", "doc": "&quot;Request Handler: Delete a resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_getResource", "name": "SehrGut\\Laravel5_Api\\Controller::getResource", "doc": "&quot;Fetch a single record from the DB and store it to $this-&gt;resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_getCollection", "name": "SehrGut\\Laravel5_Api\\Controller::getCollection", "doc": "&quot;Fetch a Collection of Resources from the databse and store it to $this-&gt;collection.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_formatResource", "name": "SehrGut\\Laravel5_Api\\Controller::formatResource", "doc": "&quot;Generate the response data using our Formatter.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_formatCollection", "name": "SehrGut\\Laravel5_Api\\Controller::formatCollection", "doc": "&quot;Generate the response data using our Formatter.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_filterByRequest", "name": "SehrGut\\Laravel5_Api\\Controller::filterByRequest", "doc": "&quot;Apply filters based on the $key_mapping. If a key is present in the\nrequest, an appropriate where clause will be added to the query.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_gatherInput", "name": "SehrGut\\Laravel5_Api\\Controller::gatherInput", "doc": "&quot;Get the request data from the adapter and\nstore it to $this-&gt;input.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_validateInput", "name": "SehrGut\\Laravel5_Api\\Controller::validateInput", "doc": "&quot;Validate the input data using the appropriate validator.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_createResource", "name": "SehrGut\\Laravel5_Api\\Controller::createResource", "doc": "&quot;Create a new instance of the current Model, fill it\nwith the input data, save it to the database and\nload it anew to get all attributes populated.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_updateResource", "name": "SehrGut\\Laravel5_Api\\Controller::updateResource", "doc": "&quot;Update the resource with the input data.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_destroyResource", "name": "SehrGut\\Laravel5_Api\\Controller::destroyResource", "doc": "&quot;Delete the resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_makeResponse", "name": "SehrGut\\Laravel5_Api\\Controller::makeResponse", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_refreshResource", "name": "SehrGut\\Laravel5_Api\\Controller::refreshResource", "doc": "&quot;Load a fresh instance of the current resource from the database.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_makeModelMapping", "name": "SehrGut\\Laravel5_Api\\Controller::makeModelMapping", "doc": "&quot;Return a ModelMapping instance.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_makeFormatter", "name": "SehrGut\\Laravel5_Api\\Controller::makeFormatter", "doc": "&quot;Return a Formatter instance.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_makeRequestAdapter", "name": "SehrGut\\Laravel5_Api\\Controller::makeRequestAdapter", "doc": "&quot;Return a RequestAdapter instance.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_authorizeAction", "name": "SehrGut\\Laravel5_Api\\Controller::authorizeAction", "doc": "&quot;Make sure the authenticated user is allowed to\nperform this type of $action.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_authorizeResource", "name": "SehrGut\\Laravel5_Api\\Controller::authorizeResource", "doc": "&quot;Make sure the authenticated user is allowed to perform\nthis type of $action on $this-&gt;resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_adaptResourceQuery", "name": "SehrGut\\Laravel5_Api\\Controller::adaptResourceQuery", "doc": "&quot;A hook to customize the query for all single resource queries.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_adaptCollectionQuery", "name": "SehrGut\\Laravel5_Api\\Controller::adaptCollectionQuery", "doc": "&quot;A hook to customize the query for all collection queries.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_adaptRules", "name": "SehrGut\\Laravel5_Api\\Controller::adaptRules", "doc": "&quot;This is the place to manipulate the validation rules at runtime.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_beforeSave", "name": "SehrGut\\Laravel5_Api\\Controller::beforeSave", "doc": "&quot;Hook in here to customize the input before saving a resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_afterSave", "name": "SehrGut\\Laravel5_Api\\Controller::afterSave", "doc": "&quot;Hook in here to customize actions after saving a resource&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_beforeCreate", "name": "SehrGut\\Laravel5_Api\\Controller::beforeCreate", "doc": "&quot;Hook in here to customize the input before creating a resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_beforeUpdate", "name": "SehrGut\\Laravel5_Api\\Controller::beforeUpdate", "doc": "&quot;Hook in here to customize the input before updating a resource.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Controller", "fromLink": "SehrGut/Laravel5_Api/Controller.html", "link": "SehrGut/Laravel5_Api/Controller.html#method_afterConstruct", "name": "SehrGut\\Laravel5_Api\\Controller::afterConstruct", "doc": "&quot;Use this hook to apply custom logic after\nthe controller instance has been created.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Exceptions", "fromLink": "SehrGut/Laravel5_Api/Exceptions.html", "link": "SehrGut/Laravel5_Api/Exceptions/Exception.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Exception", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Exception", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Exception.html", "link": "SehrGut/Laravel5_Api/Exceptions/Exception.html#method_errorResponse", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Exception::errorResponse", "doc": "&quot;Gather the message status and error and return\nthem as a formatted JSON response.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Exception", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Exception.html", "link": "SehrGut/Laravel5_Api/Exceptions/Exception.html#method_getStatus", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Exception::getStatus", "doc": "&quot;Get the HTTP status associated with this Exception (if applicable).&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Formatter", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Formatter.html", "link": "SehrGut/Laravel5_Api/Exceptions/Formatter/FormatterException.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Formatter\\FormatterException", "doc": "&quot;&quot;"},
                    
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Formatter", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Formatter.html", "link": "SehrGut/Laravel5_Api/Exceptions/Formatter/InvalidData.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Formatter\\InvalidData", "doc": "&quot;&quot;"},
                    
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Http", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Http.html", "link": "SehrGut/Laravel5_Api/Exceptions/Http/HttpException.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Http\\HttpException", "doc": "&quot;&quot;"},
                    
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Http", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Http.html", "link": "SehrGut/Laravel5_Api/Exceptions/Http/NotFound.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Http\\NotFound", "doc": "&quot;&quot;"},
                    
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Validator", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Validator.html", "link": "SehrGut/Laravel5_Api/Exceptions/Validator/InvalidInput.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Validator\\InvalidInput", "doc": "&quot;&quot;"},
                    
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Validator", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Validator.html", "link": "SehrGut/Laravel5_Api/Exceptions/Validator/ValidatorException.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Validator\\ValidatorException", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Validator\\ValidatorException", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Validator/ValidatorException.html", "link": "SehrGut/Laravel5_Api/Exceptions/Validator/ValidatorException.html#method___construct", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Validator\\ValidatorException::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Exceptions\\Validator\\ValidatorException", "fromLink": "SehrGut/Laravel5_Api/Exceptions/Validator/ValidatorException.html", "link": "SehrGut/Laravel5_Api/Exceptions/Validator/ValidatorException.html#method_errorResponse", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Validator\\ValidatorException::errorResponse", "doc": "&quot;Gather the message status and error and return\nthem as a formatted JSON response.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Formatters", "fromLink": "SehrGut/Laravel5_Api/Formatters.html", "link": "SehrGut/Laravel5_Api/Formatters/Formatter.html", "name": "SehrGut\\Laravel5_Api\\Formatters\\Formatter", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\Formatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/Formatter.html", "link": "SehrGut/Laravel5_Api/Formatters/Formatter.html#method___construct", "name": "SehrGut\\Laravel5_Api\\Formatters\\Formatter::__construct", "doc": "&quot;Create a new instance.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\Formatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/Formatter.html", "link": "SehrGut/Laravel5_Api/Formatters/Formatter.html#method_format", "name": "SehrGut\\Laravel5_Api\\Formatters\\Formatter::format", "doc": "&quot;Generate a HTTP response body from an Eloquent Collection or Model.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\Formatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/Formatter.html", "link": "SehrGut/Laravel5_Api/Formatters/Formatter.html#method_formatResource", "name": "SehrGut\\Laravel5_Api\\Formatters\\Formatter::formatResource", "doc": "&quot;Format a single record.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\Formatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/Formatter.html", "link": "SehrGut/Laravel5_Api/Formatters/Formatter.html#method_formatCollection", "name": "SehrGut\\Laravel5_Api\\Formatters\\Formatter::formatCollection", "doc": "&quot;Format an entire collection.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\Formatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/Formatter.html", "link": "SehrGut/Laravel5_Api/Formatters/Formatter.html#method_serialize", "name": "SehrGut\\Laravel5_Api\\Formatters\\Formatter::serialize", "doc": "&quot;Turn the transformed data into a JSON string.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\Formatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/Formatter.html", "link": "SehrGut/Laravel5_Api/Formatters/Formatter.html#method_transform", "name": "SehrGut\\Laravel5_Api\\Formatters\\Formatter::transform", "doc": "&quot;Apply the transformer to an Eloquent Model.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Formatters", "fromLink": "SehrGut/Laravel5_Api/Formatters.html", "link": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html", "name": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html", "link": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html#method_format", "name": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter::format", "doc": "&quot;Generate a HTTP response body from an Eloquent Collection or Model.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html", "link": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html#method_formatResource", "name": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter::formatResource", "doc": "&quot;Format a single record.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html", "link": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html#method_getModelType", "name": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter::getModelType", "doc": "&quot;master(Functional programming)&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api", "fromLink": "SehrGut/Laravel5_Api.html", "link": "SehrGut/Laravel5_Api/ModelMapping.html", "name": "SehrGut\\Laravel5_Api\\ModelMapping", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\ModelMapping", "fromLink": "SehrGut/Laravel5_Api/ModelMapping.html", "link": "SehrGut/Laravel5_Api/ModelMapping.html#method_getTransformerFor", "name": "SehrGut\\Laravel5_Api\\ModelMapping::getTransformerFor", "doc": "&quot;Get the Transformer for a specific model.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\ModelMapping", "fromLink": "SehrGut/Laravel5_Api/ModelMapping.html", "link": "SehrGut/Laravel5_Api/ModelMapping.html#method_getValidatorFor", "name": "SehrGut\\Laravel5_Api\\ModelMapping::getValidatorFor", "doc": "&quot;Get the Validator for a specific model.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\ModelMapping", "fromLink": "SehrGut/Laravel5_Api/ModelMapping.html", "link": "SehrGut/Laravel5_Api/ModelMapping.html#method_getUrlFor", "name": "SehrGut\\Laravel5_Api\\ModelMapping::getUrlFor", "doc": "&quot;Get the url for a specific model.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api", "fromLink": "SehrGut/Laravel5_Api.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html", "name": "SehrGut\\Laravel5_Api\\RequestAdapter", "doc": "&quot;This basic RequestAdapter assumes the keys are part of the url or the\nquery string and therefore available as properties of the request.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\RequestAdapter", "fromLink": "SehrGut/Laravel5_Api/RequestAdapter.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html#method___construct", "name": "SehrGut\\Laravel5_Api\\RequestAdapter::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\RequestAdapter", "fromLink": "SehrGut/Laravel5_Api/RequestAdapter.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html#method_hasKey", "name": "SehrGut\\Laravel5_Api\\RequestAdapter::hasKey", "doc": "&quot;Check if a given key exists in the request.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\RequestAdapter", "fromLink": "SehrGut/Laravel5_Api/RequestAdapter.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html#method_getValueByKey", "name": "SehrGut\\Laravel5_Api\\RequestAdapter::getValueByKey", "doc": "&quot;Get the value for a given key.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\RequestAdapter", "fromLink": "SehrGut/Laravel5_Api/RequestAdapter.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html#method_getPayload", "name": "SehrGut\\Laravel5_Api\\RequestAdapter::getPayload", "doc": "&quot;Get the request payload.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api", "fromLink": "SehrGut/Laravel5_Api.html", "link": "SehrGut/Laravel5_Api/Transformer.html", "name": "SehrGut\\Laravel5_Api\\Transformer", "doc": "&quot;Responsible for applying transformations to Eloquent Models\nin order to customize their representation at the API.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method___construct", "name": "SehrGut\\Laravel5_Api\\Transformer::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_transform", "name": "SehrGut\\Laravel5_Api\\Transformer::transform", "doc": "&quot;Transform a single eloquent record.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_handleRelations", "name": "SehrGut\\Laravel5_Api\\Transformer::handleRelations", "doc": "&quot;Add the relations to the output.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_addRelation", "name": "SehrGut\\Laravel5_Api\\Transformer::addRelation", "doc": "&quot;Add a single relation.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_transformAny", "name": "SehrGut\\Laravel5_Api\\Transformer::transformAny", "doc": "&quot;Transform either Collection or Model using the known $model_mapping.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_dropAttributes", "name": "SehrGut\\Laravel5_Api\\Transformer::dropAttributes", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_formatAttributes", "name": "SehrGut\\Laravel5_Api\\Transformer::formatAttributes", "doc": "&quot;Format all attributes if a function exists that matches their name.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_alias", "name": "SehrGut\\Laravel5_Api\\Transformer::alias", "doc": "&quot;Apply all rules in $this-&gt;aliases and replace key accordingly in output.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_beforeSerialize", "name": "SehrGut\\Laravel5_Api\\Transformer::beforeSerialize", "doc": "&quot;Here you can hook in to change the output before serializing.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformer.html#method_serialize", "name": "SehrGut\\Laravel5_Api\\Transformer::serialize", "doc": "&quot;Serialize a single record to an array.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api", "fromLink": "SehrGut/Laravel5_Api.html", "link": "SehrGut/Laravel5_Api/Validator.html", "name": "SehrGut\\Laravel5_Api\\Validator", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Validator", "fromLink": "SehrGut/Laravel5_Api/Validator.html", "link": "SehrGut/Laravel5_Api/Validator.html#method_getRules", "name": "SehrGut\\Laravel5_Api\\Validator::getRules", "doc": "&quot;Retrieve the rules of this validator.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Validator", "fromLink": "SehrGut/Laravel5_Api/Validator.html", "link": "SehrGut/Laravel5_Api/Validator.html#method_validate", "name": "SehrGut\\Laravel5_Api\\Validator::validate", "doc": "&quot;Validate the input using $rules.&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


