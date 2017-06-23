
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">SehrGut</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:SehrGut_Laravel5_Api" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api.html">Laravel5_Api</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:SehrGut_Laravel5_Api_Exceptions" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Exceptions.html">Exceptions</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:SehrGut_Laravel5_Api_Exceptions_Formatter" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Exceptions/Formatter.html">Formatter</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Formatter_FormatterException" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Formatter/FormatterException.html">FormatterException</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Formatter_InvalidData" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Formatter/InvalidData.html">InvalidData</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Exceptions_Http" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Exceptions/Http.html">Http</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Http_HttpException" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Http/HttpException.html">HttpException</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Http_NotFound" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Http/NotFound.html">NotFound</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Exceptions_Validator" >                    <div style="padding-left:54px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Exceptions/Validator.html">Validator</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Validator_InvalidInput" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Validator/InvalidInput.html">InvalidInput</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Validator_ValidatorException" >                    <div style="padding-left:80px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Validator/ValidatorException.html">ValidatorException</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Exceptions_Exception" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Exceptions/Exception.html">Exception</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Formatters" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Formatters.html">Formatters</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Formatters_Formatter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Formatters/Formatter.html">Formatter</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Formatters_JsonapiFormatter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html">JsonapiFormatter</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Formatters_SplitRelationsFormatter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Formatters/SplitRelationsFormatter.html">SplitRelationsFormatter</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Hooks" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Hooks.html">Hooks</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Hooks_AdaptCollectionQuery" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Hooks/AdaptCollectionQuery.html">AdaptCollectionQuery</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Hooks_AdaptResourceQuery" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Hooks/AdaptResourceQuery.html">AdaptResourceQuery</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Hooks_AuthorizeAction" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Hooks/AuthorizeAction.html">AuthorizeAction</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Hooks_AuthorizeResource" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Hooks/AuthorizeResource.html">AuthorizeResource</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Plugins" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Plugins.html">Plugins</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Plugins_Paginator" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Plugins/Paginator.html">Paginator</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Plugins_Plugin" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Plugins/Plugin.html">Plugin</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Plugins_SearchFilter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Plugins/SearchFilter.html">SearchFilter</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Plugins_TestPlugin" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Plugins/TestPlugin.html">TestPlugin</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:SehrGut_Laravel5_Api_Transformers" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="SehrGut/Laravel5_Api/Transformers.html">Transformers</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:SehrGut_Laravel5_Api_Transformers_SplitRelationsTransformer" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Transformers/SplitRelationsTransformer.html">SplitRelationsTransformer</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Transformers_Transformer" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Transformers/Transformer.html">Transformer</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_ModelMapping" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/ModelMapping.html">ModelMapping</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_RequestAdapter" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/RequestAdapter.html">RequestAdapter</a>                    </div>                </li>                            <li data-name="class:SehrGut_Laravel5_Api_Validator" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="SehrGut/Laravel5_Api/Validator.html">Validator</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "SehrGut.html", "name": "SehrGut", "doc": "Namespace SehrGut"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api.html", "name": "SehrGut\\Laravel5_Api", "doc": "Namespace SehrGut\\Laravel5_Api"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Exceptions.html", "name": "SehrGut\\Laravel5_Api\\Exceptions", "doc": "Namespace SehrGut\\Laravel5_Api\\Exceptions"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Exceptions/Formatter.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Formatter", "doc": "Namespace SehrGut\\Laravel5_Api\\Exceptions\\Formatter"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Exceptions/Http.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Http", "doc": "Namespace SehrGut\\Laravel5_Api\\Exceptions\\Http"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Exceptions/Validator.html", "name": "SehrGut\\Laravel5_Api\\Exceptions\\Validator", "doc": "Namespace SehrGut\\Laravel5_Api\\Exceptions\\Validator"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Formatters.html", "name": "SehrGut\\Laravel5_Api\\Formatters", "doc": "Namespace SehrGut\\Laravel5_Api\\Formatters"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Hooks.html", "name": "SehrGut\\Laravel5_Api\\Hooks", "doc": "Namespace SehrGut\\Laravel5_Api\\Hooks"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Plugins.html", "name": "SehrGut\\Laravel5_Api\\Plugins", "doc": "Namespace SehrGut\\Laravel5_Api\\Plugins"},{"type": "Namespace", "link": "SehrGut/Laravel5_Api/Transformers.html", "name": "SehrGut\\Laravel5_Api\\Transformers", "doc": "Namespace SehrGut\\Laravel5_Api\\Transformers"},
            {"type": "Interface", "fromName": "SehrGut\\Laravel5_Api\\Hooks", "fromLink": "SehrGut/Laravel5_Api/Hooks.html", "link": "SehrGut/Laravel5_Api/Hooks/AdaptCollectionQuery.html", "name": "SehrGut\\Laravel5_Api\\Hooks\\AdaptCollectionQuery", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Hooks\\AdaptCollectionQuery", "fromLink": "SehrGut/Laravel5_Api/Hooks/AdaptCollectionQuery.html", "link": "SehrGut/Laravel5_Api/Hooks/AdaptCollectionQuery.html#method_adaptCollectionQuery", "name": "SehrGut\\Laravel5_Api\\Hooks\\AdaptCollectionQuery::adaptCollectionQuery", "doc": "&quot;This hook receives the query on \&quot;index requests\&quot; after the request\nparameters have been applied, before the records are retrieved.&quot;"},
            
            {"type": "Interface", "fromName": "SehrGut\\Laravel5_Api\\Hooks", "fromLink": "SehrGut/Laravel5_Api/Hooks.html", "link": "SehrGut/Laravel5_Api/Hooks/AdaptResourceQuery.html", "name": "SehrGut\\Laravel5_Api\\Hooks\\AdaptResourceQuery", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Hooks\\AdaptResourceQuery", "fromLink": "SehrGut/Laravel5_Api/Hooks/AdaptResourceQuery.html", "link": "SehrGut/Laravel5_Api/Hooks/AdaptResourceQuery.html#method_adaptResourceQuery", "name": "SehrGut\\Laravel5_Api\\Hooks\\AdaptResourceQuery::adaptResourceQuery", "doc": "&quot;This hook receives the query on \&quot;single resource\&quot; requests after the\nrequest parameters have been applied, before the record is retrieved.&quot;"},
            
            {"type": "Interface", "fromName": "SehrGut\\Laravel5_Api\\Hooks", "fromLink": "SehrGut/Laravel5_Api/Hooks.html", "link": "SehrGut/Laravel5_Api/Hooks/AuthorizeAction.html", "name": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeAction", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeAction", "fromLink": "SehrGut/Laravel5_Api/Hooks/AuthorizeAction.html", "link": "SehrGut/Laravel5_Api/Hooks/AuthorizeAction.html#method_authorizeAction", "name": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeAction::authorizeAction", "doc": "&quot;Hook in here to check authorization for an action in general\n(before any records are fetched from the db).&quot;"},
            
            {"type": "Interface", "fromName": "SehrGut\\Laravel5_Api\\Hooks", "fromLink": "SehrGut/Laravel5_Api/Hooks.html", "link": "SehrGut/Laravel5_Api/Hooks/AuthorizeResource.html", "name": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeResource", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeResource", "fromLink": "SehrGut/Laravel5_Api/Hooks/AuthorizeResource.html", "link": "SehrGut/Laravel5_Api/Hooks/AuthorizeResource.html#method_authorizeResource", "name": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeResource::authorizeResource", "doc": "&quot;Hook in here to check authorization for a single resource (db record).&quot;"},
            
            
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
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Formatters", "fromLink": "SehrGut/Laravel5_Api/Formatters.html", "link": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html", "name": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter", "fromLink": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html", "link": "SehrGut/Laravel5_Api/Formatters/JsonapiFormatter.html#method_format", "name": "SehrGut\\Laravel5_Api\\Formatters\\JsonapiFormatter::format", "doc": "&quot;Generate a HTTP response body from an Eloquent Collection or Model.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Formatters", "fromLink": "SehrGut/Laravel5_Api/Formatters.html", "link": "SehrGut/Laravel5_Api/Formatters/SplitRelationsFormatter.html", "name": "SehrGut\\Laravel5_Api\\Formatters\\SplitRelationsFormatter", "doc": "&quot;This response Formatter is meant to work together with the &lt;code&gt;SplitRelationsTransformer&lt;\/code&gt;.&quot;"},
                    
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Hooks", "fromLink": "SehrGut/Laravel5_Api/Hooks.html", "link": "SehrGut/Laravel5_Api/Hooks/AdaptCollectionQuery.html", "name": "SehrGut\\Laravel5_Api\\Hooks\\AdaptCollectionQuery", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Hooks\\AdaptCollectionQuery", "fromLink": "SehrGut/Laravel5_Api/Hooks/AdaptCollectionQuery.html", "link": "SehrGut/Laravel5_Api/Hooks/AdaptCollectionQuery.html#method_adaptCollectionQuery", "name": "SehrGut\\Laravel5_Api\\Hooks\\AdaptCollectionQuery::adaptCollectionQuery", "doc": "&quot;This hook receives the query on \&quot;index requests\&quot; after the request\nparameters have been applied, before the records are retrieved.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Hooks", "fromLink": "SehrGut/Laravel5_Api/Hooks.html", "link": "SehrGut/Laravel5_Api/Hooks/AdaptResourceQuery.html", "name": "SehrGut\\Laravel5_Api\\Hooks\\AdaptResourceQuery", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Hooks\\AdaptResourceQuery", "fromLink": "SehrGut/Laravel5_Api/Hooks/AdaptResourceQuery.html", "link": "SehrGut/Laravel5_Api/Hooks/AdaptResourceQuery.html#method_adaptResourceQuery", "name": "SehrGut\\Laravel5_Api\\Hooks\\AdaptResourceQuery::adaptResourceQuery", "doc": "&quot;This hook receives the query on \&quot;single resource\&quot; requests after the\nrequest parameters have been applied, before the record is retrieved.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Hooks", "fromLink": "SehrGut/Laravel5_Api/Hooks.html", "link": "SehrGut/Laravel5_Api/Hooks/AuthorizeAction.html", "name": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeAction", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeAction", "fromLink": "SehrGut/Laravel5_Api/Hooks/AuthorizeAction.html", "link": "SehrGut/Laravel5_Api/Hooks/AuthorizeAction.html#method_authorizeAction", "name": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeAction::authorizeAction", "doc": "&quot;Hook in here to check authorization for an action in general\n(before any records are fetched from the db).&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Hooks", "fromLink": "SehrGut/Laravel5_Api/Hooks.html", "link": "SehrGut/Laravel5_Api/Hooks/AuthorizeResource.html", "name": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeResource", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeResource", "fromLink": "SehrGut/Laravel5_Api/Hooks/AuthorizeResource.html", "link": "SehrGut/Laravel5_Api/Hooks/AuthorizeResource.html#method_authorizeResource", "name": "SehrGut\\Laravel5_Api\\Hooks\\AuthorizeResource::authorizeResource", "doc": "&quot;Hook in here to check authorization for a single resource (db record).&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api", "fromLink": "SehrGut/Laravel5_Api.html", "link": "SehrGut/Laravel5_Api/ModelMapping.html", "name": "SehrGut\\Laravel5_Api\\ModelMapping", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\ModelMapping", "fromLink": "SehrGut/Laravel5_Api/ModelMapping.html", "link": "SehrGut/Laravel5_Api/ModelMapping.html#method_getTransformerFor", "name": "SehrGut\\Laravel5_Api\\ModelMapping::getTransformerFor", "doc": "&quot;Get the Transformer for a specific model.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\ModelMapping", "fromLink": "SehrGut/Laravel5_Api/ModelMapping.html", "link": "SehrGut/Laravel5_Api/ModelMapping.html#method_getValidatorFor", "name": "SehrGut\\Laravel5_Api\\ModelMapping::getValidatorFor", "doc": "&quot;Get the Validator for a specific model.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\ModelMapping", "fromLink": "SehrGut/Laravel5_Api/ModelMapping.html", "link": "SehrGut/Laravel5_Api/ModelMapping.html#method_getUrlFor", "name": "SehrGut\\Laravel5_Api\\ModelMapping::getUrlFor", "doc": "&quot;Get the url for a specific model.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Plugins", "fromLink": "SehrGut/Laravel5_Api/Plugins.html", "link": "SehrGut/Laravel5_Api/Plugins/Paginator.html", "name": "SehrGut\\Laravel5_Api\\Plugins\\Paginator", "doc": "&quot;A basic paginator that takes &lt;code&gt;limit&lt;\/code&gt; and &lt;code&gt;page&lt;\/code&gt; from the\nrequest and adapts the colleciton queries accordingly.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Plugins\\Paginator", "fromLink": "SehrGut/Laravel5_Api/Plugins/Paginator.html", "link": "SehrGut/Laravel5_Api/Plugins/Paginator.html#method_adaptCollectionQuery", "name": "SehrGut\\Laravel5_Api\\Plugins\\Paginator::adaptCollectionQuery", "doc": "&quot;This hook receives the query on \&quot;index requests\&quot; after the request\nparameters have been applied, before the records are retrieved.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Plugins", "fromLink": "SehrGut/Laravel5_Api/Plugins.html", "link": "SehrGut/Laravel5_Api/Plugins/Plugin.html", "name": "SehrGut\\Laravel5_Api\\Plugins\\Plugin", "doc": "&quot;Base plugin from which all plugins have to inherit.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Plugins\\Plugin", "fromLink": "SehrGut/Laravel5_Api/Plugins/Plugin.html", "link": "SehrGut/Laravel5_Api/Plugins/Plugin.html#method___construct", "name": "SehrGut\\Laravel5_Api\\Plugins\\Plugin::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Plugins\\Plugin", "fromLink": "SehrGut/Laravel5_Api/Plugins/Plugin.html", "link": "SehrGut/Laravel5_Api/Plugins/Plugin.html#method_configure", "name": "SehrGut\\Laravel5_Api\\Plugins\\Plugin::configure", "doc": "&quot;Set configuration options on the plugin.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Plugins", "fromLink": "SehrGut/Laravel5_Api/Plugins.html", "link": "SehrGut/Laravel5_Api/Plugins/SearchFilter.html", "name": "SehrGut\\Laravel5_Api\\Plugins\\SearchFilter", "doc": "&quot;This plugin allows filtering results index requests by applying &lt;code&gt;orWhere&lt;\/code&gt; conditions\nto the collection query, searching all &lt;code&gt;searchable&lt;\/code&gt; fields for the string\npassed in through the &lt;code&gt;search_param&lt;\/code&gt; request parameter.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Plugins\\SearchFilter", "fromLink": "SehrGut/Laravel5_Api/Plugins/SearchFilter.html", "link": "SehrGut/Laravel5_Api/Plugins/SearchFilter.html#method_adaptCollectionQuery", "name": "SehrGut\\Laravel5_Api\\Plugins\\SearchFilter::adaptCollectionQuery", "doc": "&quot;This hook receives the query on \&quot;index requests\&quot; after the request\nparameters have been applied, before the records are retrieved.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Plugins", "fromLink": "SehrGut/Laravel5_Api/Plugins.html", "link": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html", "name": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin", "doc": "&quot;This plugin is to test all hooks that exist on the Controller.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin", "fromLink": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html", "link": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html#method_adaptCollectionQuery", "name": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin::adaptCollectionQuery", "doc": "&quot;This hook receives the query on \&quot;index requests\&quot; after the request\nparameters have been applied, before the records are retrieved.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin", "fromLink": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html", "link": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html#method_adaptResourceQuery", "name": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin::adaptResourceQuery", "doc": "&quot;This hook receives the query on \&quot;single resource\&quot; requests after the\nrequest parameters have been applied, before the record is retrieved.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin", "fromLink": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html", "link": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html#method_authorizeResource", "name": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin::authorizeResource", "doc": "&quot;Hook in here to check authorization for a single resource (db record).&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin", "fromLink": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html", "link": "SehrGut/Laravel5_Api/Plugins/TestPlugin.html#method_authorizeAction", "name": "SehrGut\\Laravel5_Api\\Plugins\\TestPlugin::authorizeAction", "doc": "&quot;Hook in here to check authorization for an action in general\n(before any records are fetched from the db).&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api", "fromLink": "SehrGut/Laravel5_Api.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html", "name": "SehrGut\\Laravel5_Api\\RequestAdapter", "doc": "&quot;This basic RequestAdapter assumes the keys are part of the url or the\nquery string and therefore available as properties of the request.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\RequestAdapter", "fromLink": "SehrGut/Laravel5_Api/RequestAdapter.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html#method___construct", "name": "SehrGut\\Laravel5_Api\\RequestAdapter::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\RequestAdapter", "fromLink": "SehrGut/Laravel5_Api/RequestAdapter.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html#method_hasKey", "name": "SehrGut\\Laravel5_Api\\RequestAdapter::hasKey", "doc": "&quot;Check if a given key exists in the request.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\RequestAdapter", "fromLink": "SehrGut/Laravel5_Api/RequestAdapter.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html#method_getValueByKey", "name": "SehrGut\\Laravel5_Api\\RequestAdapter::getValueByKey", "doc": "&quot;Get the value for a given key.&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\RequestAdapter", "fromLink": "SehrGut/Laravel5_Api/RequestAdapter.html", "link": "SehrGut/Laravel5_Api/RequestAdapter.html#method_getPayload", "name": "SehrGut\\Laravel5_Api\\RequestAdapter::getPayload", "doc": "&quot;Get the request payload.&quot;"},
            
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Transformers", "fromLink": "SehrGut/Laravel5_Api/Transformers.html", "link": "SehrGut/Laravel5_Api/Transformers/SplitRelationsTransformer.html", "name": "SehrGut\\Laravel5_Api\\Transformers\\SplitRelationsTransformer", "doc": "&quot;Formatter that splits off relations and attributes and returns them as separate arrays.&quot;"},
                    
            {"type": "Class", "fromName": "SehrGut\\Laravel5_Api\\Transformers", "fromLink": "SehrGut/Laravel5_Api/Transformers.html", "link": "SehrGut/Laravel5_Api/Transformers/Transformer.html", "name": "SehrGut\\Laravel5_Api\\Transformers\\Transformer", "doc": "&quot;Responsible for applying transformations to Eloquent Models\nin order to customize their representation at the API.&quot;"},
                                                        {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformers\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformers/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformers/Transformer.html#method___construct", "name": "SehrGut\\Laravel5_Api\\Transformers\\Transformer::__construct", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "SehrGut\\Laravel5_Api\\Transformers\\Transformer", "fromLink": "SehrGut/Laravel5_Api/Transformers/Transformer.html", "link": "SehrGut/Laravel5_Api/Transformers/Transformer.html#method_transform", "name": "SehrGut\\Laravel5_Api\\Transformers\\Transformer::transform", "doc": "&quot;Transform a single eloquent record.&quot;"},
            
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


