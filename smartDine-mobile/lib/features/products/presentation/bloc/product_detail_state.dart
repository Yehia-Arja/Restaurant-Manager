import 'package:mobile/features/products/domain/entities/product.dart';

abstract class ProductDetailState {}

class DetailLoading extends ProductDetailState {}

class DetailError extends ProductDetailState {
  final String message;
  DetailError(this.message);
}

class DetailLoaded extends ProductDetailState {
  final Product product;
  DetailLoaded(this.product);
}
