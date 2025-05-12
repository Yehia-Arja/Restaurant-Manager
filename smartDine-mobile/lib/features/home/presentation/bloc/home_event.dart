import 'package:equatable/equatable.dart';

abstract class HomeEvent extends Equatable {
  const HomeEvent();

  @override
  List<Object?> get props => [];
}

class LoadHomeData extends HomeEvent {
  final int restaurantId;
  final int? branchId;

  const LoadHomeData({required this.restaurantId, this.branchId});

  @override
  List<Object?> get props => [restaurantId, branchId];
}
