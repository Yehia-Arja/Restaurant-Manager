import 'package:equatable/equatable.dart';
import 'package:mobile/features/home/domain/entities/home_data.dart';
import 'package:mobile/features/home/domain/entities/branch.dart';

abstract class HomeState extends Equatable {
  const HomeState();

  @override
  List<Object?> get props => [];

  List<Branch> get branches {
    if (this is HomeLoaded) {
      return (this as HomeLoaded).data.branches;
    }
    return [];
  }
}

class HomeInitial extends HomeState {}

class HomeLoading extends HomeState {}

class HomeLoaded extends HomeState {
  final HomeData data;

  const HomeLoaded(this.data);

  @override
  List<Object?> get props => [data];
}

class HomeError extends HomeState {
  final String message;

  const HomeError(this.message);

  @override
  List<Object?> get props => [message];
}
