abstract class SearchEvent {}

class InitSearch extends SearchEvent {
  final int branchId;
  InitSearch(this.branchId);
}

class CategoryChanged extends SearchEvent {
  final int? categoryId;
  CategoryChanged(this.categoryId);
}

class QueryChanged extends SearchEvent {
  final String query;
  QueryChanged(this.query);
}

class FetchMoreProducts extends SearchEvent {}
