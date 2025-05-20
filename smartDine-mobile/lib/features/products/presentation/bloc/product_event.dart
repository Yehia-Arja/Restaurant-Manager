import 'package:equatable/equatable.dart';

abstract class ProductEvent extends Equatable {
  const ProductEvent();

  @override
  List<Object?> get props => [];
}

class LoadProducts extends ProductEvent {
  final int branchId;
  final String? searchQuery;
  final int? categoryId;
  final bool favoritesOnly;
  final int page;

  const LoadProducts({
    required this.branchId,
    this.searchQuery,
    this.categoryId,
    this.favoritesOnly = false,
    this.page = 1,
  });

  @override
  List<Object?> get props => [branchId, searchQuery, categoryId, favoritesOnly, page];
}
