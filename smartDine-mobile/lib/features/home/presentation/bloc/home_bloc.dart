import 'package:flutter_bloc/flutter_bloc.dart';
import 'home_event.dart';
import 'home_state.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';

class HomeBloc extends Bloc<HomeEvent, HomeState> {
  final GetHomeDataUseCase _useCase;

  HomeBloc(this._useCase) : super(HomeInitial()) {
    on<LoadHomeData>(_onLoadHomeData);
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
}
