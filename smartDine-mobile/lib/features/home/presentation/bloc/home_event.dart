import 'package:equatable/equatable.dart';

abstract class HomeEvent extends Equatable {
  const HomeEvent();

  @override
  List<Object?> get props => [];
}

// Event to load home data
class LoadHomeData extends HomeEvent {
  final int restaurantId;
  final int? branchId;

  const LoadHomeData({required this.restaurantId, this.branchId});

  @override
  List<Object?> get props => [restaurantId, branchId];
}

// Event to toggle favorite for a product
class ToggleFavoriteInHome extends HomeEvent {
  final int productId;

  const ToggleFavoriteInHome(this.productId);

  @override
  List<Object?> get props => [productId];
}
