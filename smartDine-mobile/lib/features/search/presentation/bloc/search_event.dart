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
  final bool favoritesOnly;
  QueryChanged(this.query, {this.favoritesOnly = false});
}

class FetchMoreProducts extends SearchEvent {}

class ToggleSearchProductFavorite extends SearchEvent {
  final int productId;
  ToggleSearchProductFavorite(this.productId);
}
