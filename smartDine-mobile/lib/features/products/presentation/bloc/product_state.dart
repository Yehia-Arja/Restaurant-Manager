import 'package:equatable/equatable.dart';
import 'package:mobile/features/products/domain/entities/product.dart';

abstract class ProductState extends Equatable {
  const ProductState();

  @override
  List<Object?> get props => [];
}

class ProductInitial extends ProductState {}

class ProductLoading extends ProductState {}

class ProductLoaded extends ProductState {
  final List<Product> products;
  final int currentPage;
  final int totalPages;
  final bool isFetchingMore;

  const ProductLoaded({
    required this.products,
    required this.currentPage,
    required this.totalPages,
    this.isFetchingMore = false,
  });

  bool get hasMore => currentPage < totalPages;

  @override
  List<Object?> get props => [products, currentPage, totalPages, isFetchingMore];
}

class ProductError extends ProductState {
  final String message;

  const ProductError(this.message);

  @override
  List<Object?> get props => [message];
}
