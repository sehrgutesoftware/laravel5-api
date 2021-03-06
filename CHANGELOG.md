# Changelog (sehrgut/laravel5-api)

## v0.2.0
- Can now count relations defined in `Controller::$counts` (see ["Counting Related Models"](https://laravel.com/docs/5.3/eloquent-relationships#counting-related-models))
- Requires now Laravel ~5.2

## v0.3.0
- Add SplitRelationsTransformer and -Formatter classes

## v0.4.0
- Introduce Plugins as a more flexible alternative to the old "hook methods"

### v0.4.1
- Make plugins configurable
- Add SearchFilter plugin

### v0.4.2
- SearchFilter plugin can search on (nested) relationships

## v0.5.0
- Remove Formatters alltogether (replace with plugin hooks)
- Paginator plugin adds meta info to reponse headers (optionally to payload)
- New Plugin: RelationSplitter (replaces SplitRelationsFormatter)

### v0.5.1
- RelationSplitter:
	- Also split relations on 'resource' requests
	- Add 'ignore_relations' config option

### v0.5.2
- Offer `$last_page` as paginator meta value

### v0.5.3
- Add Authorization Plugin
- Prepare for Plugin testing

## v0.6.0
- Introduce controller `context` for plugin interaction
- Allow controller to implement hooks itself
- Migrate most deprecated hooks

### v0.6.1
- Fix a bug in RelationSplitter, add tests and refactor

### v0.6.2
- RelationSplitter: Add `ignore_pivots` config options

### v0.6.4
- Bugfix: RelationSplitter falsely added plain ids to includes

### v0.6.5
- Allow adding counts to side-loads (using dot-notation)

## v0.7.0
- **Breaking:** Context is now a property of Plugins instead of an argument to Hooks
- Introduce `BeginAction` and `AdaptRelations` hooks

### v0.7.1
- Bugfix when loading relations with nested counts

### v0.7.2
- Performance improvement in RelationSplitter

### v0.7.3
- Bugfix RelationSplitter

### v0.7.4
- Slightly optimize the way Transformation works

### v0.7.5
- Introduce `saveMany` action

### v0.7.6
- Bugfix
- Compatibility Laravel 5.6, PHP 7.2

### v0.7.7
- Bugfix in Paginator plugin

### v0.7.8
- Slight improvement in Paginator plugin
