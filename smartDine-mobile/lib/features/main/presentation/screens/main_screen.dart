import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/core/blocs/selected_branch_cubit.dart';
import 'package:mobile/features/home/presentation/screens/home_screen.dart';
import 'package:mobile/features/search/presentation/screens/search_screen.dart';
import 'package:mobile/shared/widgets/bottom_navigation_bar.dart';
import 'package:mobile/features/assistant/presentation/screens/assistant_screen.dart';
import 'package:mobile/features/home/presentation/bloc/home_bloc.dart';
import 'package:mobile/features/home/presentation/bloc/home_event.dart';
import 'package:mobile/features/home/presentation/bloc/home_state.dart';
import 'package:mobile/features/search/presentation/bloc/search_bloc.dart';
import 'package:mobile/features/search/presentation/bloc/search_event.dart';
import 'package:mobile/features/assistant/presentation/bloc/chat_bloc.dart';
import 'package:mobile/features/assistant/presentation/bloc/chat_event.dart';
import 'package:mobile/features/assistant/domain/usecases/send_message_usecase.dart';
import 'package:mobile/features/assistant/domain/usecases/get_chat_history_usecase.dart';

class MainScreen extends StatefulWidget {
  const MainScreen({Key? key}) : super(key: key);

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _currentIndex = 0;
  late final int _restaurantId;
  int? _lastBranchId;

  @override
  void initState() {
    super.initState();

    _restaurantId = context.read<SelectedRestaurantCubit>().state!;
    context.read<HomeBloc>().add(LoadHomeData(restaurantId: _restaurantId, branchId: null));

    context.read<SelectedBranchCubit>().stream.listen((newBranchId) {
      if (newBranchId != null && newBranchId != _lastBranchId) {
        _lastBranchId = newBranchId;
        context.read<HomeBloc>().add(
          LoadHomeData(restaurantId: _restaurantId, branchId: newBranchId),
        );
        context.read<SearchBloc>().add(InitSearch(newBranchId));
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    final sendMessage = context.read<SendMessage>();
    final getChatHistory = context.read<GetChatHistory>();

    return BlocListener<HomeBloc, HomeState>(
      listener: (context, state) {
        if (state is HomeLoaded && context.read<SelectedBranchCubit>().state == null) {
          final defaultBranch = state.data.branches.first;
          context.read<SelectedBranchCubit>().select(defaultBranch.id);
        }
      },
      child: Builder(
        builder: (context) {
          final branchId = context.watch<SelectedBranchCubit>().state;

          final screens = <Widget>[
            const HomeScreen(),
            const SearchScreen(),
            const Placeholder(key: ValueKey('seat')),
            if (branchId != null)
              BlocProvider(
                key: ValueKey('assistant_$branchId'),
                create:
                    (_) =>
                        ChatBloc(getChatHistory: getChatHistory, sendMessage: sendMessage)
                          ..add(FetchChatHistory(branchId)),
                child: AssistantScreen(branchId: branchId, sendMessageUseCase: sendMessage),
              )
            else
              const Center(child: Text('Please select a branch first')),
            const Placeholder(key: ValueKey('activity')),
          ];

          return Scaffold(
            extendBodyBehindAppBar: true,
            body: IndexedStack(index: _currentIndex, children: screens),
            bottomNavigationBar: PrimaryBottomNavBar(
              currentIndex: _currentIndex,
              onTap: (i) => setState(() => _currentIndex = i),
            ),
          );
        },
      ),
    );
  }
}
