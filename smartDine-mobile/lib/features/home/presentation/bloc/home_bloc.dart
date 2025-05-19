import 'package:flutter_bloc/flutter_bloc.dart';
import 'home_event.dart';
import 'home_state.dart';

import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';
import 'package:mobile/features/favorite/domain/usecases/toggle_favorite_usecase.dart';

class HomeBloc extends Bloc<HomeEvent, HomeState> {
  final GetHomeDataUseCase _useCase;
  final ToggleFavoriteUseCase _toggleFavorite;

  HomeBloc(this._useCase, this._toggleFavorite) : super(HomeInitial()) {
    on<LoadHomeData>(_onLoadHomeData);
    on<ToggleFavoriteInHome>(_onToggleFavorite);
  }

  Future<void> _onLoadHomeData(LoadHomeData event, Emitter<HomeState> emit) async {
    emit(HomeLoading());
    try {
      final data = await _useCase.call(restaurantId: event.restaurantId, branchId: event.branchId);
      emit(HomeLoaded(data));
    } catch (e) {
      emit(HomeError(e.toString()));
    }
  }

  Future<void> _onToggleFavorite(ToggleFavoriteInHome event, Emitter<HomeState> emit) async {
    if (state is! HomeLoaded) return;
    final current = state as HomeLoaded;

    final products = [...current.data.products];
    final idx = products.indexWhere((p) => p.id == event.productId);
    if (idx == -1) return;

    final original = products[idx];
    final toggled = original.copyWith(isFavorited: !original.isFavorited);
    products[idx] = toggled;

    emit(HomeLoaded(current.data.copyWith(products: products)));

    try {
      await _toggleFavorite(id: original.id, type: 'product');
    } catch (_) {
      products[idx] = original;
      emit(HomeLoaded(current.data.copyWith(products: products)));
    }
  }
}
