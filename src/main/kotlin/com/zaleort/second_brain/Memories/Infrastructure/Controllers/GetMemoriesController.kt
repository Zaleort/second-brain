package com.zaleort.second_brain.Memories.Infrastructure.Controllers

import com.zaleort.second_brain.Memories.Application.UseCases.GetMemories.GetMemoriesCommand
import com.zaleort.second_brain.Memories.Application.UseCases.GetMemories.GetMemoriesHandler
import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.RestController

@RestController
class GetMemoriesController(
    private val handler: GetMemoriesHandler,
) {
    @GetMapping("/api/v1/memories")
    fun getMemories(
        @AuthenticationPrincipal user: UserDetails,
    ): ResponseEntity<List<MemoryDTO>> {

        val userId = user.username
        val memories = handler.execute(GetMemoriesCommand(
            userId = userId,
        ))
        return ResponseEntity(memories, HttpStatus.OK)
    }
}