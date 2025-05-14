abstract class SearchEvent {}

// Fire once on init to load cats + first page of products
class InitSearch extends SearchEvent {}

// User tapped a chip
class CategoryChanged extends SearchEvent {
  final int? categoryId;
  CategoryChanged(this.categoryId);
}

// User typed in the search bar
class QueryChanged extends SearchEvent {
  final String query;
  QueryChanged(this.query);
}

// Scroll hit bottom
class FetchMoreProducts extends SearchEvent {}
