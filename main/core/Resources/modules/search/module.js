import angular from 'angular/index'
import 'angular-ui-select'

import Interceptors from '../interceptorsDefault'
import ClarolineSearchDirective from './Directive/ClarolineSearchDirective'
import ClarolineSearchService from './Service/ClarolineSearchService'
import SearchOptionsService  from './Service/SearchOptionsService'

angular.module('ClarolineSearch', ['ui.select'])
	.config(Interceptors)
	.directive('clarolinesearch', () => new ClarolineSearchDirective)
	.service('SearchOptionsService', () => new SearchOptionsService)
	.provider('ClarolineSearchService', () => new ClarolineSearchService)
