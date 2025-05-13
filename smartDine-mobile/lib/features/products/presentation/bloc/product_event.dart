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

  const LoadProducts({required this.branchId, this.searchQuery, this.categoryId});

  @override
  List<Object?> get props => [branchId, searchQuery, categoryId];
}
